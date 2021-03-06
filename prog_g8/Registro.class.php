<?php 
error_reporting(E_ALL);
ini_set('diplay_errors',1);
include_once $_SERVER['DOCUMENT_ROOT']."/prog_g8/desenv/db/MySQL.class.php";

class Registro
{
	private $id_registro;
	private $id_internacao;
	private $medicamento;
	private $procedimento;
	private $reacao;
	private $visibilidade;
	private $id_atendente;
	private $dt_registro;
	private $dt_procedimento;
    private $atendente;

	public function __construct($id_registro, $id_internacao=null, $medicamento=null, $procedimento=null, $reacao=null, $visibilidade=null, $id_atendente=null, $dt_registro=null, $dt_procedimento=null)
	{
		$this->id_registro = $id_registro;
		$this->id_internacao = $id_internacao;
		$this->medicamento = $medicamento;
		$this->procedimento = $procedimento;
		$this->reacao = $reacao;
		$this->visibilidade = $visibilidade;
		$this->id_atendente = $id_atendente;
		$this->dt_registro = $dt_registro;
		$this->dt_procedimento = $dt_procedimento;
	}

    public function getid_registro()
    {
        return $this->id_registro;
    }

    public function getid_internacao()
    {
        return $this->id_internacao;
    }

    public function getMedicamento()
    {
        return $this->medicamento;
    }

    public function getProcedimento()
    {
        return $this->procedimento;
    }

    public function getReacao()
    {
        return $this->reacao;
    }

    public function getVisibilidade()
    {
        return $this->visibilidade;
    }

    public function getid_atendente()
    {
        return $this->id_atendente;
    }

    public function getdt_registro()
    {
        return $this->dt_registro;
    }

    public function getdt_procedimento()
    {
        return $this->dt_procedimento;
    }

    public function getatendente()
    {
        return $this->atendente;

    }


    public function inserir(){
            $con = new MySQL();
            $sql = "INSERT INTO registro (id_internacao, medicamento, procedimento, reacao, visibilidade, id_atendente, dt_registro, dt_procedimento) 
                VALUES ('$this->id_internacao','$this->medicamento','$this->procedimento','$this->reacao',$this->visibilidade, '$this->id_atendente','$this->dt_registro','$this->dt_procedimento')";
               $con->executa($sql); 
            $sql_id = "SELECT id_registro FROM registro WHERE id_atendente=$this->id_atendente and dt_registro ='$this->dt_registro' and id_internacao = $this->id_internacao";
            $id = $con->consulta($sql_id);
            return $id;
    }

        public function editar(){
            $con = new MySQL();
            $sql = "UPDATE registro SET medicamento ='$this->medicamento',procedimento ='$this->procedimento', reacao='$this->reacao', visibilidade = '$this->visibilidade', dt_registro = '$this->dt_registro', dt_procedimento = '$this->dt_procedimento'  WHERE id_registro = $this->id_registro";
            $con->executa($sql);
            return $this->id_registro;
        }

        public function listarUm(){
                $con = new MySQL();
                $sql = "SELECT * FROM registro WHERE id_registro = $this->id_registro";
                $resultado = $con->consulta($sql);
                if(!empty($resultado)){
                        $this->id_internacao = $resultado[0]['id_internacao'];
                        $this->medicamento = $resultado[0]['medicamento'];
                        $this->procedimento = $resultado[0]['procedimento'];
                        $this->reacao = $resultado[0]['reacao'];
                        $this->visibilidade = $resultado[0]['visibilidade'];
                        $this->id_atendente = $resultado[0]['id_atendente'];
                        $this->dt_registro = $resultado[0]['dt_registro'];
                        $this->dt_procedimento = $resultado[0]['dt_procedimento'];
                }
                else{
                    return false;
                }
        }

        public function listarPorInternacao($id_internacao){
        $con = new MySQL();
            $sql = "SELECT registro.*, usuario.nome FROM registro, usuario WHERE usuario.id_usuario = registro.id_atendente AND id_internacao = $id_internacao order by dt_procedimento desc" ;
            $dados = $con->consulta($sql);
            if(!empty($dados)){
                 
                $registros = array();
                foreach($dados as $dado){
                    $registro = new Registro($dado['id_registro'], $dado['id_internacao'], $dado['medicamento'], $dado['procedimento'], $dado['reacao'], $dado['visibilidade'], $dado['nome'], $dado['dt_registro'], $dado['dt_procedimento']);
                    $registros[] = $registro;
                   
                }
                 return $registros;
            }else{
                return false;
            }
        }

        public static function listaIdentificacao($id_internacao){
            $conexao = new MySQL();
            $internacao =  $id_internacao;
            $pet = $conexao->consulta("SELECT  nomeP FROM paciente, internacao WHERE internacao.id_internacao = $id_internacao and internacao.id_usuario = paciente.id_usuario ");
            $quarto = $conexao->consulta("SELECT quarto.descricao FROM quarto, internacao WHERE internacao.id_internacao = $id_internacao and internacao.id_quarto = quarto.id_quarto");
            $infos = array();
            $infos["pet"] = $pet[0]['nomeP'];
            $infos["quarto"] = $quarto[0]["descricao"];
            return $infos;
        }

        /*public static function listaIdentificacao2(){
            $conexao = new MySQL();
            $internacao = $this->id_internacao;
            $pet = $conexao->consulta("SELECT  nomeP FROM paciente, internacao WHERE internacao.id_internacao = $this->id_internacao and internacao.id_usuario = paciente.id_usuario ");
            $quarto = $conexao->consulta("SELECT quarto.descricao FROM quarto, internacao WHERE internacao.id_internacao = $this->id_internacao and internacao.id_quarto = quarto.id_quarto");
            $infos = array();
            $infos["pet"] = $pet[0]['nomeP'];
            $infos["quarto"] = $quarto[0]["descricao"];
            return $infos;
        }*/
}

?>