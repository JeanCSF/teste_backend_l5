<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class Api extends ResourceController
{
    private $clientesModel;
    private $produtosModel;
    private $pedidosModel;
    private $usuariosModel;
    private $secretKey;


    private function gerarResponse($codigo, $mensagem = '', $erros = [], $dados = [], $token = null)
    {
        $mensagens = [
            200 => 'Sucesso: ',
            400 => 'Erro de validação: ',
            401 => 'Não autorizado: ',
            404 => 'Não encontrado: ',
            500 => 'Erro interno: '
        ];

        $mensagemFinal = isset($mensagens[$codigo]) ? $mensagens[$codigo] . $mensagem : $mensagem;

        $resposta = [
            'cabecalho' => [
                'status' => $codigo,
                'mensagem' => $mensagemFinal
            ]
        ];

        if ($codigo == 400 && !empty($erros)) {
            $resposta['cabecalho']['erros'] = $erros;
        }

        if ($codigo == 200 && !empty($dados)) {
            $resposta['retorno'] = $dados;
        }

        if ($token) {
            $resposta['token'] = $token;
        }

        return $this->respond($resposta, $codigo);
    }

    private function gerarJWT($usuario, $secretKey)
    {
        $payload = [
            'iss' => 'localhost',
            'iat' => time(),
            'exp' => time() + 3600,
            'usuario' => $usuario['usuario']
        ];

        return JWT::encode($payload, $secretKey, 'HS256');
    }

    private function _validarJWT()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        if (!$authHeader) {
            return $this->gerarResponse(401, 'Token ausente');
        }

        $token = explode(' ', $authHeader)[1];

        try {
            $secretKey = getenv('JWT_SECRET_KEY');
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

            return $decoded;
        } catch (Exception $e) {
            return $this->gerarResponse(401, $e->getMessage());
        }
    }

    private function gerarModel($rota)
    {
        switch ($rota) {
            case 'cliente':
            case 'clientes':
                return $this->clientesModel;

            case 'produto':
            case 'produtos':
                return $this->produtosModel;

            case 'pedido':
            case 'pedidos':
                return  $this->pedidosModel;
        }
    }

    public function __construct()
    {
        $this->clientesModel = new \App\Models\ClientesModel();
        $this->produtosModel = new \App\Models\ProdutosModel();
        $this->pedidosModel = new \App\Models\PedidosModel();
        $this->usuariosModel = new \App\Models\UsuariosModel();
        $this->secretKey = getenv('JWT_SECRET_KEY');
        $this->session = \Config\Services::session();
    }

    public function login()
    {
        $post = $this->request->getJSON();
        if (empty($post->usuario) && empty($post->senha)) {
            return $this->gerarResponse(400, 'Verifique os dados fornecidos', ["usuario" => 'Nenhum usuario informado', "senha" => 'Nenhuma senha informada']);
        }

        if (empty($post->usuario)) {
            return $this->gerarResponse(400, 'Verifique os dados fornecidos', ["usuario" => 'Nenhum usuario informado']);
        }

        if (empty($post->senha)) {
            return $this->gerarResponse(400, 'Verifique os dados fornecidos', ["senha" => 'Nenhuma senha informada']);
        }

        try {
            $usuario = $this->usuariosModel->autenticar($post);

            if (!empty($usuario)) {
                $token = $this->gerarJWT($usuario, $this->secretKey);
                $sessionData = [
                    'userId' => $usuario['id'],
                    'username' => $usuario['usuario'],
                ];
                $this->session->set($sessionData);
                return $this->gerarResponse(200, 'Login efetuado com sucesso', [], [], $token);
            }

            return $this->gerarResponse(401, 'Usuario ou senha inválidos');
        } catch (Exception $e) {
            return $this->gerarResponse(500, $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            $this->session->destroy();
            redirect()->to('/');
            return $this->gerarResponse(200, 'Logout efetuado com sucesso');
        } catch (Exception $e) {
            return $this->gerarResponse(500, $e->getMessage());
        }
    }

    public function listar()
    {
        $jwtValidation = $this->_validarJWT();
        if ($jwtValidation instanceof \CodeIgniter\HTTP\Response) {
            return $jwtValidation;
        }

        $rota = $this->request->getUri()->getSegment(2);
        $model = $this->gerarModel($rota);

        $post = $this->request->getJSON();
        $limit = $post->parametros->limit ?? 10;
        $page = $post->parametros->page ?? 1;
        $q = isset($post->parametros->q) ? (string) $post->parametros->q : null;

        try {
            $totalRegistros = $model->countAllResults();
            if ($page > ceil($totalRegistros / $limit)) {
                return $this->gerarResponse(404, 'Página solicitada não encontrada');
            }

            $response = $model->getAll($limit, $page, $q);
            if (!empty($response)) {
                return $this->respond($response);
            }

            return $this->gerarResponse(404, 'Nenhum registro encontrado');
        } catch (Exception $e) {
            return $this->gerarResponse(500, $e->getMessage());
        }
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $jwtValidation = $this->_validarJWT();
        if ($jwtValidation instanceof \CodeIgniter\HTTP\Response) {
            return $jwtValidation;
        }

        $rota = $this->request->getUri()->getSegment(3);
        $model = $this->gerarModel($rota);
        $post = $this->request->getJSON();

        try {
            if ($model->insert($post->parametros)) {
                return $this->gerarResponse(201, 'Registro criado com sucesso');
            }

            $erros = $model->errors();
            if (!empty($erros)) {
                return $this->gerarResponse(400, 'Verifique os dados fornecidos', $erros);
            }
        } catch (Exception $e) {
            return $this->gerarResponse(500, $e->getMessage());
        }
    }

    public function read()
    {
        $jwtValidation = $this->_validarJWT();
        if ($jwtValidation instanceof \CodeIgniter\HTTP\Response) {
            return $jwtValidation;
        }

        $rota = $this->request->getUri()->getSegment(3);
        $model = $this->gerarModel($rota);
        $post = $this->request->getJSON();

        if (empty($post->parametros->id)) {
            return $this->gerarResponse(400, 'Verifique os dados fornecidos', ["id" => 'Nenhum ID informado']);
        }

        try {
            $dados = $model->find($post->parametros->id);
            if (empty($dados)) {
                return $this->gerarResponse(404, 'Nenhum registro encontrado');
            }

            return $this->gerarResponse(200, 'Dados retornados com sucesso', [], $dados);
        } catch (Exception $e) {
            return $this->gerarResponse(500, $e->getMessage());
        }
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $jwtValidation = $this->_validarJWT();
        if ($jwtValidation instanceof \CodeIgniter\HTTP\Response) {
            return $jwtValidation;
        }

        $post = $this->request->getJSON();
        if (empty($post->parametros->id)) {
            return $this->gerarResponse(400, 'Verifique os dados fornecidos', ["id" => 'Nenhum ID informado']);
        }

        $rota = $this->request->getUri()->getSegment(3);
        $model = $this->gerarModel($rota);

        try {
            if (!$model->find($post->parametros->id)) {
                return $this->gerarResponse(404, 'Registro não encontrado');
            }

            if ($model->update($post->parametros->id, $post->parametros)) {
                return $this->gerarResponse(200, 'Registro atualizado com sucesso');
            }

            $erros = $model->errors();
            if (!empty($erros)) {
                return $this->gerarResponse(400, 'Verifique os dados fornecidos', $erros);
            }
        } catch (Exception $e) {
            return $this->gerarResponse(500, $e->getMessage());
        }
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $jwtValidation = $this->_validarJWT();
        if ($jwtValidation instanceof \CodeIgniter\HTTP\Response) {
            return $jwtValidation;
        }

        $rota = $this->request->getUri()->getSegment(3);
        $model = $this->gerarModel($rota);

        try {
            if (!$model->find($id)) {
                return $this->gerarResponse(404, 'Registro não encontrado');
            }

            $model->delete($id);
            return $this->gerarResponse(200, 'Registro excluído com sucesso');
        } catch (Exception $e) {
            return $this->gerarResponse(500, $e->getMessage());
        }
    }
}
