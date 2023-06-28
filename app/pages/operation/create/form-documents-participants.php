<?php
// Funções para obter dados da API
require_once "api/operation.php";

$attachments = apiOperationAttachmentsTypeGet();
?>

<div class="col-xs-12">
    <div class="form-group">
        <label for="inputOperationName">Nome da operação*</label>
        <input type="text" class="form-control" name="operation-name" id="inputOperationName" required placeholder="Insira o nome da operação aqui">
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="inputOperationFile">Inserir documentos*</label>
        <input type="file" class="form-control" name="operation-files[]" id="inputOperationFile" required placeholder="Selecionar ou arrastar arquivos (pdf)" multiple accept=".pdf">
        <small class="form-text" id="inputOperationFileHelp">Adicione os documentos que serão assinados (somente extensão PDF e até 10 MB por operação)</small>
    </div>
</div>

<h2 class="h4 fw-normal">Participantes</h1>

    <div class="col-xs-12 col-sm-3">
        <div class="form-group">
            <label for="inputOperationMembersQuantity">Participantes da operação*</label>
            <input type="number" class="form-control" name="operation-members-quantity" id="inputOperationMembersQuantity" required value="1" min="1" disabled>
            <small class="form-text" id="inputOperationMembersQuantityHelp">Adicione os participantes da sua operação</small><br />&nbsp;
        </div>
    </div>

    <div class="col-xs-12">
        <div class="row g-2 form-member">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="inputOperationMemberName0">Nome e sobrenome*</label>
                    <input type="text" class="form-control" name="operation-member-name" id="inputOperationMemberName0" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group">
                    <label for="inputOperationMemberEmail0">E-mail*</label>
                    <input type="email" class="form-control" name="operation-member-email" id="inputOperationMemberEmail0" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-2">
                <div class="form-group">
                    <label for="inputOperationMemberPhone0">Telefone</label>
                    <input type="tel" class="form-control" name="operation-member-phone" id="inputOperationMemberPhone0">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="inputOperationMemberRole0">Função</label>
                    <input type="text" class="form-control" name="operation-member-role" id="inputOperationMemberRole0">
                </div>
            </div>
            <div class="col-xs-12">
                <div class="accordion" id="accordionMember0">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button type="button" title="Mais opções para este participante" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"></button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionMember0">
                            <div class="accordion-body row g-2">
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group">
                                        <label for="inputOperationMemberNotificationChannel0">Canal de notificação</label>
                                        <select class="form-select" name="operation-member-notification-channel" id="inputOperationMemberNotificationChannel0">
                                            <option value="Email">E-mail (padrão)</option>
                                            <option disabled value="SMS">SMS</option>
                                            <option disabled value="WhatsApp">WhatsApp</option>
                                            <option value="None">Não notificar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group">
                                        <label for="inputOperationMemberSign0">Assinatura</label>
                                        <select class="form-select" name="operation-member-signature" id="inputOperationMemberSign0">
                                            <option value="Click">Assinatura com um clique</option>
                                            <option value="Draw" disabled>Assinatura com desenho</option>
                                            <option value="Text" disabled>Assinatura com texto</option>
                                            <option value="UserChoice" disabled>Desenho ou texto (padrão)</option>
                                            <option value="Stamp" disabled>Plotagem</option>
                                            <option value="AutomaticStamp" disabled>Plotagem automática</option>
                                            <option value="Rubric" disabled>Rúbrica</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group">
                                        <label for="inputOperationMemberAuthentication0">Autenticação</label>
                                        <select class="form-select" name="operation-member-authentication" id="inputOperationMemberAuthentication0">
                                            <option value="Email">E-mail</option>
                                            <option disabled value="SMS">SMS</option>
                                            <option disabled value="WhatsApp">WhatsApp</option>
                                            <option value="" selected>Nenhuma (padrão)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="mb-1">Anexos</label>
                                        <br />
                                        <?php
                                        if (isset($attachments->data)) {
                                            foreach ($attachments->data as $index => $option) {
                                                $option->fileType = explode(',', $option->fileType);
                                                $value = urlencode(json_encode($option));
                                                echo <<<HTML
                                            <div class="form-check form-check-inline form-switch">
                                                <input class="form-check-input" type="checkbox" name="operation-member-attachments[]" value="{$value}" role="switch" id="operationMemberAttachments0{$index}">
                                                <label class="form-check-label" for="operationMemberAttachments0{$index}" title="{$option->description}">{$option->name}</label>
                                            </div>
                                            HTML;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3">
        <div class="col-xs-12 text-sm-end">
            <button type="submit" name="step" value="1" class="btn btn-secondary">Continuar</button>
        </div>
    </div>