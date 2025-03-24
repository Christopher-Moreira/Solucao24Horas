
<?php
class WelcomeView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        // Container principal
        $container = new TElement('div');
        $container->class = 'container';
        $container->style = 'max-width: 1200px; margin: 40px auto; padding: 20px;';
        
        // Header com ícone
        $header = new TElement('div');
        $header->class = 'd-flex align-items-center mb-4';
        
        $icon = new TElement('i');
        $icon->class = 'fas fa-rocket fa-3x text-primary mr-3';
        
        $titleContainer = new TElement('div');
        $title = new TElement('h1');
        $title->style = 'color: #2c3e50; font-weight: 300; margin: 0;';
        $title->add('Bem-vindo ao Solução24Horas - Admin');
        
        $subtitle = new TElement('p');
        $subtitle->style = 'color: #7f8c8d; font-size: 1.2em; margin: 5px 0 0 0;';
        $subtitle->add('Sua plataforma de gestão integrada');
        
        $titleContainer->add($title);
        $titleContainer->add($subtitle);
        $header->add($icon);
        $header->add($titleContainer);
        $container->add($header);

        // Grid de funcionalidades
        $features = new TElement('div');
        $features->class = 'row';
        $features->style = 'margin: 30px 0;';
        
        $featureItems = [
            ['icon' => 'fas fa-users', 'title' => 'Gestão de Leads', 'text' => 'Controle completo de clientes potenciais'],
            ['icon' => 'fas fa-chart-line', 'title' => 'Analytics', 'text' => 'Relatórios e métricas em tempo real'],
            ['icon' => 'fas fa-cogs', 'title' => 'Automação', 'text' => 'Processos automatizados e agendamentos'],
            ['icon' => 'fas fa-shield-alt', 'title' => 'Segurança', 'text' => 'Dados protegidos e criptografados']
        ];
        
        foreach ($featureItems as $item) {
            $col = new TElement('div');
            $col->class = 'col-md-3 mb-4';
            
            $card = new TElement('div');
            $card->class = 'card h-100 shadow-sm';
            $card->style = 'border: 1px solid #e0e0e0; border-radius: 10px;';
            
            $cardBody = new TElement('div');
            $cardBody->class = 'card-body text-center';
            
            $icon = new TElement('i');
            $icon->class = $item['icon'] . ' fa-2x text-primary mb-3';
            
            $title = new TElement('h5');
            $title->class = 'card-title';
            $title->style = 'color: #34495e;';
            $title->add($item['title']);
            
            $text = new TElement('p');
            $text->class = 'card-text';
            $text->style = 'color: #7f8c8d; font-size: 0.9em;';
            $text->add($item['text']);
            
            $cardBody->add($icon);
            $cardBody->add($title);
            $cardBody->add($text);
            $card->add($cardBody);
            $col->add($card);
            $features->add($col);
        }
        $container->add($features);

        // Últimas atualizações
        $updateSection = new TElement('div');
        $updateSection->class = 'card border-primary mb-4';
        $updateSection->style = 'border-radius: 10px;';
        
        $header = new TElement('div');
        $header->class = 'card-header bg-primary text-white';
        $header->style = 'border-radius: 9px 9px 0 0;';
        $header->add('<i class="fas fa-clipboard-list mr-2"></i>Últimas Atualizações');
        
        $body = new TElement('div');
        $body->class = 'card-body';
        
        $updateList = new TElement('div');
        $updateList->style = 'list-style: none; padding: 0;';
        
        $updates = [

            
            ['version' => '1.1.0', 'date' => '22/02/2025', 'items' => [
                'Checkboxes para seleção em massa de usuários',
                'Otimização do sistema de importação'
                
            ]],
            ['version' => '1.0.2', 'date' => '15/02/2025', 'items' => [
                'Correções de segurança',
                'Melhorias na interface'
            ]],
            ['version' => '1.0.3', 'date' => '24/03/2025', 'items' => [
                'Mudanças visuais.'
            ]]

        ];
        
        foreach ($updates as $update) {
            $updateItem = new TElement('div');
            $updateItem->class = 'mb-3';
            
            $version = new TElement('div');
            $version->class = 'd-flex align-items-center mb-2';
            $version->add('<i class="fas fa-code-branch mr-2 text-muted"></i>');
            $version->add('<strong class="mr-2">Versão ' . $update['version'] . '</strong>');
            $version->add('<small class="text-muted">' . $update['date'] . '</small>');
            
            $list = new TElement('ul');
            $list->style = 'margin: 5px 0 0 25px; color: #555;';
            
            foreach ($update['items'] as $item) {
                $li = new TElement('li');
                $li->add($item);
                $list->add($li);
            }
            
            $updateItem->add($version);
            $updateItem->add($list);
            $updateList->add($updateItem);
        }
        
        $body->add($updateList);
        $updateSection->add($header);
        $updateSection->add($body);
        $container->add($updateSection);

        // Ações rápidas
        $quickActions = new TElement('div');
        $quickActions->class = 'card border-info';
        $quickActions->style = 'border-radius: 10px;';
        
        $header = new TElement('div');
        $header->class = 'card-header bg-info text-white';
        $header->style = 'border-radius: 9px 9px 0 0;';
        $header->add('<i class="fas fa-bolt mr-2"></i>Ações Rápidas');
        
        $body = new TElement('div');
        $body->class = 'card-body';
        $body->style = 'padding: 20px;';
        
        $actions = new TElement('div');
        $actions->class = 'd-flex justify-content-around flex-wrap';
        
        $actionItems = [
        
        ];
        
        foreach ($actionItems as $item) {
            $btn = new TElement('button');
            $btn->class = 'btn btn-' . $item['color'] . ' mb-2';
            $btn->style = 'min-width: 200px; margin: 5px;';
            $btn->add('<i class="' . $item['icon'] . ' mr-2"></i>' . $item['text']);
            $actions->add($btn);
        }
        
        $body->add($actions);
        $quickActions->add($header);
        $quickActions->add($body);
       

        parent::add($container);
    }
}