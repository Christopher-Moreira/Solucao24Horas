<?php
// Inclui os arquivos necessários do Adianti Framework
require_once 'init.php';
use Adianti\Control\TPage;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Database\TTransaction;
use Adianti\Widget\Base\TElement;

class ListaNomesPage extends TPage
{
    public function __construct()
    {
        parent::__construct();

        // Captura o CPF da URL
        $cpf = isset($_GET['cpf']) ? $_GET['cpf'] : null;

        // Cria o DataGrid
        $datagrid = new TDataGrid;

        // Adiciona uma coluna ao DataGrid
        $celularColumn = new TDataGridColumn('celular', 'Celular', 'left');
        $datagrid->addColumn($celularColumn);

        $datagrid->createModel();

        try {
            TTransaction::open('api'); // Substitua 'api' pelo nome da sua conexão configurada no Adianti

            // Consulta SQL para buscar o celular com base no CPF
            $sql = "SELECT celular FROM celulares WHERE cpf = :cpf";
            $conn = TTransaction::get(); // Obtém a conexão ativa
            $stmt = $conn->prepare($sql);
            $stmt->execute([':cpf' => $cpf]);

            // Adiciona cada linha do resultado ao DataGrid
            foreach ($stmt as $row) {
                $item = new stdClass();
                $item->celular = $row['celular'];
                $datagrid->addItem($item);
            }

            TTransaction::close(); // Fecha a transação
        } catch (Exception $e) {
            // Em caso de erro, exibe a mensagem e desfaz a transação
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }

        // Adiciona o DataGrid à página
        parent::add($datagrid);
    }
}

// Executa a página
$page = new ListaNomesPage();
$page->show();
