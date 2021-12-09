Заказать обратный звонок
=============

## 1. Настройка Веб-форм

Переходим в настройки ``Веб-форм`` и создаём новую форму

![alt text](https://raw.githubusercontent.com/dwstroy/API_bitrix/main/IncludeComponent/bFormResultNew/callback/_img/01.jpeg)

![alt text](https://raw.githubusercontent.com/dwstroy/API_bitrix/main/IncludeComponent/bFormResultNew/callback/_img/02.jpeg)

На вкладке ``вопросы`` создаём инпуты

![alt text](https://raw.githubusercontent.com/dwstroy/API_bitrix/main/IncludeComponent/bFormResultNew/callback/_img/03.jpeg)

Скачиваем модуль [Настройки++](https://marketplace.1c-bitrix.ru/solutions/askaron.settings/) для ``SITE_KEY`` и ``SECRET_KEY`` у Recaptcha 3. <br>
В настройках модуля заводим поля **RECAPTCHA_SITE_KEY (ключ сайта)** и **RECAPTCHA_SECRET_KEY (Секретный ключ)** <br>
Ключи получаем тут [www.google.com/recaptcha](https://www.google.com/recaptcha/admin/site/494263442) <br>

![alt text](https://raw.githubusercontent.com/dwstroy/API_bitrix/main/IncludeComponent/bFormResultNew/callback/_img/04.jpeg)

## 2. Вёрстка саомой формы

Описание ``CSS`` стилей
``` css
.portfolio-ajax-modal.ajax-modal-max-450 { 
    max-width: 450px; 
    border: 1px solid #8d8b8b; 
} 
.ajax-modal-title { 
    background-color: #F9F9F9; 
    border-bottom: 1px solid #eee; 
    padding: 25px 40px; 
} 
.ajax-modal-title h2 { 
    font-size: 26px; 
    margin-bottom: 0; 
} 
.modal-padding { 
    padding: 40px; 
} 
.col_full { 
    clear: both; 
    float: none; 
    margin-right: 0; 
    width: 100%; 
    margin-bottom: 0; 
} 
form .col_full { 
    margin-bottom: 25px; 
} 
label { 
    letter-spacing: 0; 
    text-transform: none; 
    display: inline-block; 
    font-size: 13px; 
    font-weight: 700; 
    color: #555; 
    margin-bottom: 10px; 
    cursor: pointer; 
    max-width: 100%; 
} 
.sm-form-control { 
    height: auto; 
    display: block; 
    width: 100%; 
    padding: 8px 14px; 
    font-size: 15px; 
    line-height: 1.42857143; 
    color: #555555; 
    background-color: #ffffff; 
    background-image: none; 
    border: 2px solid #ddd; 
    -webkit-border-radius: 0 !important; 
    -moz-border-radius: 0 !important; 
    border-radius: 0 !important; 
    -webkit-transition: border-color ease-in-out .15s; 
    -o-transition: border-color ease-in-out .15s; 
    transition: border-color ease-in-out .15s; 
} 
.button { 
    display: inline-block; 
    position: relative; 
    cursor: pointer; 
    outline: none; 
    white-space: nowrap; 
    margin: 5px; 
    padding: 0 22px; 
    font-size: 14px; 
    height: 40px; 
    line-height: 40px; 
    background-color: #017ac3; 
    color: #FFF; 
    font-weight: 600; 
    text-transform: uppercase; 
    border: none; 
    text-shadow: 1px 1px 1px rgb(0 0 0 / 20%); 
} 
.response { 
    display: none; 
} 
.response.alert-success { 
    display: block; 
} 
._error_text { 
    color: red; 
    font-size: 11px; 
}
```

Описание ``HTML``

``` html
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
```
