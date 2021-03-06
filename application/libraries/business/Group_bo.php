<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author djalmocruzjr (djalmo.cruz@gmail.com)
 * @version 1.0
 * @since 28/08/2016
 *
 * Classe para aplicar as regras de negocio inerentes as operacoes do controller <i>Account</i>.
 */
class Group_bo
{

    protected $CI;

    /**
     * @var array
     *
     * Recebe os dados a serem validados.
     */
    private $data;

    /**
     * @var array
     *
     * Armazena os erros inerentes ao processo de validacao.
     */
    private $errors;

    /**
     * Account_bo constructor.
     */
    public function __construct()
    {
        // Loading variables
        $this->data = [];
        $this->errors = [];
        $this->CI = &get_instance();

        // Loading model
        $this->CI->load->model('areainteresse_model');
        $this->CI->load->model('usuario_model');
        $this->CI->load->model('grupo_model');
    }

    /**
     * @param array $data
     *
     * Metodo para setar os dados a serem validados.
     */
    public function set_data($data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * Metodo para retornar os dados apos serem validados.
     */
    public function get_data()
    {
        return $this->data;
    }

    /**
     * @return array
     *
     * Metodo para retornar os erros inerentes ao processo de validacao.
     */
    public function get_errors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     *
     * Metodo para validar os dados inentes ao processo de <i>list_all</i> do controller <i>Group</i>.
     */
    public function validate_list_all()
    {
        $status = TRUE;

        // Verifica se o decode do JSON foi feito corretamente
        if (is_null($this->data)) {
            $this->errors['json_decode'] = "Não foi possível realizar o decode dos dados. JSON inválido!";
            return false;
        }

        // Validando o campo <i>usnid</i> (ID do usuario)
        if (!isset($this->data['usnid']) || empty(trim($this->data['usnid']))) {
            $this->errors['usnid'] = 'O ID do usuário é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['usnid'])) {
            $this->errors['usnid'] = 'O ID do usuário deve ser um valor inteiro!';
            $status = FALSE;
        }

        return $status;
    }

    /**
     * @return bool
     *
     * Metodo para validar os dados inentes ao processo de <i>get</i> do controller <i>Group</i>.
     */
    public function validate_get()
    {
        $status = TRUE;

        // Verifica se o decode do JSON foi feito corretamente
        if (is_null($this->data)) {
            $this->errors['json_decode'] = "Não foi possível realizar o decode dos dados. JSON inválido!";
            return false;
        }

        // Validando o campo <i>grnid</i> (ID do Grupo)
        if (!isset($this->data['grnid']) || empty(trim($this->data['grnid']))) {
            $this->errors['grnid'] = 'O ID DO GRUPO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['grnid'])) {
            $this->errors['grnid'] = 'O ID DO GRUPO deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->grupo_model->find_by_grnid($this->data['grnid']))) {
            $this->errors['grnid'] = 'ID DO GRUPO inválido!';
            $status = FALSE;
        }

        return $status;
    }

    /**
     * @return bool
     *
     * Metodo para validar os dados inentes ao processo de <i>add</i> do controller <i>Group</i>.
     */
    public function validate_add()
    {
        $status = TRUE;

        // Verifica se o decode do JSON foi feito corretamente
        if (is_null($this->data)) {
            $this->errors['json_decode'] = "Não foi possível realizar o decode dos dados. JSON inválido!";
            return false;
        }

        // Validando o campo <i>grcnome</i> (Nome do Grupo)
        if (!isset($this->data['grcnome']) || empty(trim($this->data['grcnome']))) {
            $this->errors['grcnome'] = 'O NOME DO GRUPO é obrigatório!';
            $status = FALSE;
        } else if (strlen($this->data['grcnome']) > GRCNOME_MAX_LENGTH) {
            $this->errors['grcnome'] = 'O NOME DO GRUPO deve conter no máximo ' . GRCNOME_MAX_LENGTH . ' caracter(es)!';
            $status = FALSE;
        }

        // Validando o campo <i>grcfoto</i> (Foto do Grupo)
        if (isset($this->data['grcfoto'])) {
            if (empty(trim($this->data['grcfoto']))) {
                $this->errors['grcfoto'] = 'A FOTO DO GRUPO é obrigatória!';
                $status = FALSE;
            }
        }

        // Validando o campo <i>grnidai</i> (ID da Area de Interesse)
        if (!isset($this->data['grnidai']) || empty(trim($this->data['grnidai']))) {
            $this->errors['grnidai'] = 'O ID DA ÁREA DE INTERESSE é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['grnidai'])) {
            $this->errors['grnidai'] = 'O ID DA ÁREA DE INTERESSE deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->areainteresse_model->find_by_ainid($this->data['grnidai']))) {
            $this->errors['grnidai'] = 'ID DA ÁREA DE INTERESSE inválido!';
            $status = FALSE;
        }

        // Validando o campo <i>usnid</i> (ID do usuario)
        if (!isset($this->data['usnid']) || empty(trim($this->data['usnid']))) {
            $this->errors['usnid'] = 'O ID DO USUÁRIO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['usnid'])) {
            $this->errors['usnid'] = 'O ID USUÁRIO deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->usuario_model->find_by_usnid($this->data['usnid']))) {
            $this->errors['usnid'] = 'ID USUÁRIO inválido!';
            $status = FALSE;
        }

        // Validando o campo <i>grctipo</i> (Tipo de Grupo)
        if (!isset($this->data['grctipo']) || empty(trim($this->data['grctipo']))) {
            $this->errors['grctipo'] = 'O TIPO DE GRUPO é obrigatório!';
            $status = FALSE;
        } else if (!is_string($this->data['grctipo']) || strlen($this->data['grctipo']) !== 1 ||
            !(strcmp($this->data['grctipo'], GRCTIPO_ABERTO) == 0 | strcmp($this->data['grctipo'], GRCTIPO_FECHADO) == 0)
        ) {
            $tipos = GRCTIPO_ABERTO . ',' . GRCTIPO_FECHADO;
            $this->errors['grctipo'] = 'O TIPO DE GRUPO deve ser um valor do tipo String (' . $tipos . ')!';
            $status = FALSE;
        }

        return $status;
    }

    /**
     * @return bool
     *
     * Metodo para validar os dados inentes ao processo de <i>edit</i> do controller <i>Group</i>.
     */
    public function validate_edit()
    {
        $status = TRUE;

        // Verifica se o decode do JSON foi feito corretamente
        if (is_null($this->data)) {
            $this->errors['json_decode'] = "Não foi possível realizar o decode dos dados. JSON inválido!";
            return false;
        }

        // Validando o campo <i>usnid</i> (ID do usuario)
        if (!isset($this->data['usnid']) || empty(trim($this->data['usnid']))) {
            $this->errors['usnid'] = 'O ID DO USUÁRIO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['usnid'])) {
            $this->errors['usnid'] = 'O ID USUÁRIO deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->usuario_model->find_by_usnid($this->data['usnid']))) {
            $this->errors['usnid'] = 'ID USUÁRIO inválido!';
            $status = FALSE;
        }

        // Validando o campo <i>grnid</i> (ID do Grupo)
        if (!isset($this->data['grnid']) || empty(trim($this->data['grnid']))) {
            $this->errors['grnid'] = 'O ID GO GRUPO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['grnid'])) {
            $this->errors['grnid'] = 'O ID DO GRUPO deve ser um valor inteiro!';
            $status = FALSE;
        }

        // Validando o campo <i>grcnome</i> (Nome do Grupo)
        if (!isset($this->data['grcnome']) || empty(trim($this->data['grcnome']))) {
            $this->errors['grcnome'] = 'O NOME DO GRUPO do usuário é obrigatório!';
            $status = FALSE;
        } else if (strlen($this->data['grcnome']) > GRCNOME_MAX_LENGTH) {
            $this->errors['grcnome'] = 'O NOME DO GRUPO deve conter no máximo ' . GRCNOME_MAX_LENGTH . ' caracter(es)!';
            $status = FALSE;
        }

        // Validando o campo <i>grcfoto</i> (Foto do Grupo)
        if (isset($this->data['grcfoto'])) {
            if (empty(trim($this->data['grcfoto']))) {
                $this->errors['grcfoto'] = 'A FOTO DO GRUPO é obrigatória!';
                $status = FALSE;
            }
        }

        // Validando o campo <i>grnidai</i> (ID da Area de Interesse)
        if (!isset($this->data['grnidai']) || empty(trim($this->data['grnidai']))) {
            $this->errors['grnidai'] = 'O ID DA ÁREA DE INTERESSE é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['grnidai'])) {
            $this->errors['grnidai'] = 'O ID DA ÁREA DE INTERESSE deve ser um valor inteiro!';
            $status = FALSE;
        }

        // Validando o campo <i>grctipo</i> (Tipo de Grupo)
        if (!isset($this->data['grctipo']) || empty(trim($this->data['grctipo']))) {
            $this->errors['grctipo'] = 'O TIPO DE GRUPO é obrigatório!';
            $status = FALSE;
        } else if (!is_string($this->data['grctipo']) || strlen($this->data['grctipo']) !== 1 ||
            !(strcmp($this->data['grctipo'], GRCTIPO_ABERTO) == 0 | strcmp($this->data['grctipo'], GRCTIPO_FECHADO) == 0)
        ) {
            $tipos = GRCTIPO_ABERTO . ',' . GRCTIPO_FECHADO;
            $this->errors['grctipo'] = 'O TIPO DE GRUPO deve ser um valor do tipo caractere (' . $tipos . ')!';
            $status = FALSE;
        }

        return $status;
    }

    /**
     * @return bool
     *
     * Metodo para validar os dados inentes ao processo de <i>delete</i> do controller <i>Group</i>.
     */
    public function validate_delete()
    {
        $status = TRUE;

        // Verifica se o decode do JSON foi feito corretamente
        if (is_null($this->data)) {
            $this->errors['json_decode'] = "Não foi possível realizar o decode dos dados. JSON inválido!";
            return false;
        }

        // Validando o campo <i>grnid</i> (ID do Grupo)
        if (!isset($this->data['grnid']) || empty(trim($this->data['grnid']))) {
            $this->errors['grnid'] = 'O ID DO GRUPO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['grnid'])) {
            $this->errors['grnid'] = 'O ID DO GRUPO deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->grupo_model->find_by_grnid($this->data['grnid']))) {
            $this->errors['grnid'] = 'ID DO GRUPO inválido!';
            $status = FALSE;
        }

        // Validando o campo <i>usnid</i> (ID do usuario)
        if (!isset($this->data['usnid']) || empty(trim($this->data['usnid']))) {
            $this->errors['usnid'] = 'O ID USUÁRIO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['grnid'])) {
            $this->errors['usnid'] = 'O ID DO USUÁRIO deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->usuario_model->find_by_usnid($this->data['usnid']))) {
            $this->errors['usnid'] = 'ID DO USUÁRIO inválido!';
            $status = FALSE;
        }

        return $status;
    }

    /**
     * @return bool
     *
     * Metodo para validar os dados inentes ao processo de <i>info</i> do controller <i>Group</i>.
     */
    public function validate_info()
    {
        $status = TRUE;

        // Verifica se o decode do JSON foi feito corretamente
        if (is_null($this->data)) {
            $this->errors['json_decode'] = "Não foi possível realizar o decode dos dados. JSON inválido!";
            return false;
        }

        // Validando o campo <i>grnid</i> (ID do Grupo)
        if (!isset($this->data['grnid']) || empty(trim($this->data['grnid']))) {
            $this->errors['grnid'] = 'O ID DO GRUPO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['grnid'])) {
            $this->errors['grnid'] = 'O ID DO GRUPO deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->grupo_model->find_by_grnid($this->data['grnid']))) {
            $this->errors['grnid'] = 'ID DO GRUPO inválido!';
            $status = FALSE;
        }

        return $status;
    }

    /**
     * @return bool
     *
     * Metodo para validar os dados inentes ao processo de <i>search</i> do controller <i>Group</i>.
     */
    public function validate_search()
    {
        $status = TRUE;

        // Verifica se o decode do JSON foi feito corretamente
        if (is_null($this->data)) {
            $this->errors['json_decode'] = "Não foi possível realizar o decode dos dados. JSON inválido!";
            return false;
        }

        // Validando o campo REFERENCE (Referenca para pesquisa)*
        if (!isset($this->data['reference']) || empty(trim($this->data['reference']))) {
            $this->errors['reference'] = 'Informe uma referência para a pesquisa!';
            $status = FALSE;
        } else if (!is_string($this->data['reference'])) {
            $this->errors['reference'] = 'A REFERÊNCIA deve ser um valor alfanumérico!';
            $status = FALSE;
        }

        return $status;
    }

    /**
     * @return bool
     *
     * Metodo para validar os dados inentes ao processo de <i>subscribe</i> do controller <i>Group</i>.
     */
    public function validate_subscribe()
    {
        $status = TRUE;

        // Verifica se o decode do JSON foi feito corretamente
        if (is_null($this->data)) {
            $this->errors['json_decode'] = "Não foi possível realizar o decode dos dados. JSON inválido!";
            return false;
        }

        // Validando o campo <i>grnid</i> (ID do Grupo)
        if (!isset($this->data['grnid']) || empty(trim($this->data['grnid']))) {
            $this->errors['grnid'] = 'O ID DO GRUPO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['grnid'])) {
            $this->errors['grnid'] = 'O ID DO GRUPO deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->grupo_model->find_by_grnid($this->data['grnid']))) {
            $this->errors['grnid'] = 'ID DO GRUPO inválido!';
            $status = FALSE;
        }

        // Validando o campo <i>usnid</i> (ID do usuario)
        if (!isset($this->data['usnid']) || empty(trim($this->data['usnid']))) {
            $this->errors['usnid'] = 'O ID DO USUÁRIO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['usnid'])) {
            $this->errors['usnid'] = 'O ID DO USUÁRIO deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->usuario_model->find_by_usnid($this->data['usnid']))) {
            $this->errors['usnid'] = 'ID DO USUÁRIO inválido!';
            $status = FALSE;
        }

        return $status;
    }

    /**
     * @return bool
     *
     * Metodo para validar os dados inentes ao processo de <i>unsubscribe</i> do controller <i>Group</i>.
     */
    public function validate_unsubscribe()
    {
        $status = TRUE;

        // Verifica se o decode do JSON foi feito corretamente
        if (is_null($this->data)) {
            $this->errors['json_decode'] = "Não foi possível realizar o decode dos dados. JSON inválido!";
            return false;
        }

        // Validando o campo <i>grnid</i> (ID do Grupo)
        if (!isset($this->data['grnid']) || empty(trim($this->data['grnid']))) {
            $this->errors['grnid'] = 'O ID DO GRUPO é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['grnid'])) {
            $this->errors['grnid'] = 'O ID DO GRUPO deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->grupo_model->find_by_grnid($this->data['grnid']))) {
            $this->errors['grnid'] = 'ID DO GRUPO inválido!';
            $status = FALSE;
        }

        // Validando o campo <i>usnid</i> (ID do usuario admin do grupo)
        if (!isset($this->data['usnid']) || empty(trim($this->data['usnid']))) {
            $this->errors['usnid'] = 'O ID DO USUÁRIO ADMIN é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['usnid'])) {
            $this->errors['usnid'] = 'O ID DO USUÁRIO ADMIN deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->usuario_model->find_by_usnid($this->data['usnid']))) {
            $this->errors['usnid'] = 'ID DO USUÁRIO ADMIN inválido!';
            $status = FALSE;
        }

        // Validando o campo <i>usnid2</i> (ID do usuario a ser removido)
        if (!isset($this->data['usnid2']) || empty(trim($this->data['usnid2']))) {
            $this->errors['usnid2'] = 'O ID DO USUÁRIO A REMOVER é obrigatório!';
            $status = FALSE;
        } else if (!is_numeric($this->data['usnid'])) {
            $this->errors['usnid2'] = 'O ID DO USUÁRIO A REMOVER deve ser um valor inteiro!';
            $status = FALSE;
        } else if (is_null($this->CI->usuario_model->find_by_usnid($this->data['usnid2']))) {
            $this->errors['usnid2'] = 'ID DO USUÁRIO A REMOVER inválido!';
            $status = FALSE;
        }

        return $status;
    }
}