<?
// Вёрстка
//bitrix\templates\eshop_bootstrap_v4\components\bitrix\form.result.new\callback\template.php
?>
<div class="portfolio-ajax-modal ajax-modal-max-450">
    <div class="ajax-modal-title">
        <h2>Заказать обратный звонок</h2>
    </div>
    <div class="modal-padding">
        <div class="col_full">
            <form>
                <div class="col_full">
                    <label>Ваше имя<span class="starrequired">*</span></label>
                    <input type="text" class="sm-form-control" required=""  value="">
                </div>
                <div class="col_full">
                    <label>Номер телефона<span class="starrequired">*</span></label>
                    <input type="text" class="sm-form-control" required="" value="">
                </div>
                <div class="col_full">
                    <input type="checkbox" required="" value="Y" checked="checked">
                    <label for="agreecheckboxL9nefh">
                        Я согласен на <a target="_blank" href="/agreement/">обработку персональных данных</a>
                    </label>
                </div>
                <div class="col_full">
                    <input type="hidden" value="Y">
                    <input class="button" type="submit" value="Отправить">
                </div>
            </form>
        </div>
    </div>
</div>