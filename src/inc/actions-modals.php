<?php
  $closeButtonHtml = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve"> <g> <path class="close_path1" d="M22.5,6h-21C1.2,6,1,5.8,1,5.5C1,5.2,1.2,5,1.5,5h21C22.8,5,23,5.2,23,5.5C23,5.8,22.8,6,22.5,6z" data-svg-origin="12 5.5" transform="matrix(0.7071,0.7071,-0.7071,0.7071,7.4038059222874395,0.12563132923541787)" style="z-index: 0;"></path> <path class="close_path2" d="M22.5,13h-21C1.2,13,1,12.8,1,12.5C1,12.2,1.2,12,1.5,12h21c0.3,0,0.5,0.2,0.5,0.5C23,12.8,22.8,13,22.5,13z" data-svg-origin="1 12" transform="matrix(0,0,0,1,12,0)" style="z-index: 0;"></path> <path class="close_path3" d="M22.5,20h-21C1.2,20,1,19.8,1,19.5C1,19.2,1.2,19,1.5,19h21c0.3,0,0.5,0.2,0.5,0.5C23,19.8,22.8,20,22.5,20z" data-svg-origin="12 19.5" transform="matrix(0.7071,-0.7071,0.7071,0.7071,-10.27386360737625,7.196699141100892)" style="z-index: 0;"></path></g></svg>';
?>
<!-- ORDER NOW -->
<div class="remodal remodal--action remodal--order" data-remodal-id="order-now" data-remodal-options="hashTracking: false" role="dialog">
  <div data-remodal-action="close" class="remodal-close" aria-label="Close">
    <?php echo $closeButtonHtml; ?>
  </div>
  <div class="remodal__content-wrapper">
    <div class="remodal__content">
      <h2 class="remodal__title">
        <span class="remodal--action__icon"></span>
        <span class="remodal--action__title">Онлайн-заказ</span>
      </h2>
      <div class="remodal__description">
        Оставьте свои контактные данные и наш менеджер свяжется с Вами для уточнения деталей заказа
      </div>
      <div class="remodal__body">
        <div class="site-form site-form--remodal">
          <form method="POST" action="/ajax.php">
                <input type="hidden" name="form_type" value="popup">
                <div class="form-group form-group--first">
                    <label for="user_name--order">Имя:</label>
                    <input type="text" class="form-control required" id="user_name--order" name="user_name--order" placeholder="Иван Иванов">
                </div>
                <div class="form-group ">
                    <label for="user_phone--order">Телефон:</label>
                    <input type="text" class="form-control required" id="user_phone--order" name="user_phone--order" placeholder="+79123456789">
                </div>
                <div class="form-group ">
                    <label for="user_email--order">Email:</label>
                    <input type="email" class="form-control required" id="user_email--order" name="user_email--order" placeholder="example@mail.ru">
                </div>
                <div class="form-group ">
                    <label for="comments--order">Комментарии:</label>
                    <textarea class="form-control" rows="3" id="comments--order" name="comments--order" placeholder="Не обязательно"></textarea>
                </div>

                <button type="submit" name="submit-btn" class="btn btn--yellow btn--medium btn--action-submit">Сделать онлайн-заказ</button>
            </form>

        </div>
        <div class="submit-loader submit-loader--paused">
               <div class="dot"></div>
               <div class="outline"><span></span></div>
        </div>
        <div class="submit-success" style="display:none">
          <div class="order-info__success-id">
            Номер заказа: <span id="order-info__success-id">&nbsp;</span>
          </div>
          <p class="success-text">В ближайшее время наш менеджер свяжется с Вами для уточнения деталей заказа, после чего его можно будет оплатить и запустить в работу.</p>
          <button type="button" class="btn btn--yellow btn--medium btn--action-success-close">Вернуться на сайт</button>
          <p class="success-text">Чтобы в следующий раз было легко
и быстро найти нас - <a class="addToBookmark" href="javascript:void(0)" onclick="AddToBookmark('http://стекло24.москва/')">добавьте наш сайт в избранное</a>. Спасибо!</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CONSULT NOW -->
<div class="remodal remodal--action remodal--consult" data-remodal-id="consult-now" data-remodal-options="hashTracking: false" role="dialog">
  <div data-remodal-action="close" class="remodal-close" aria-label="Close">
    <?php echo $closeButtonHtml; ?>
  </div>
  <div class="remodal__content-wrapper">
    <div class="remodal__content">
      <h2 class="remodal__title">
        <span class="remodal--action__icon"></span>
        <span class="remodal--action__title">Бесплатная консультация</span>
      </h2>
      <div class="remodal__description">
        Оставьте заявку и наш менеджер поможет Вам с выбором, расскажет все детали и нюансы
      </div>
      <div class="remodal__body">
        <div class="site-form">
          <form method="POST" action="/ajax.php">
                <input type="hidden" name="form_type" value="popup">
                <div class="form-group form-group--first">
                    <label for="user_name--consult">Имя:</label>
                    <input type="text" class="form-control required" id="user_name--consult" name="user_name--consult" placeholder="Иван Иванов">
                </div>
                <div class="form-group ">
                    <label for="user_phone--consult">Телефон:</label>
                    <input type="text" class="form-control required" id="user_phone--consult" name="user_phone--consult" placeholder="+79123456789">
                </div>
                <div class="form-group ">
                    <label for="user_question--consult">Ваш вопрос:</label>
                    <textarea class="form-control" id="user_question--consult" name="user_question--consult" placeholder="Необязательное поле" rows="5" cols="40"></textarea>
                </div>

                <button type="submit" name="submit-btn" class="btn btn--yellow btn--medium btn--action-submit">Получить консультацию</button>
            </form>
            <div class="submit-loader submit-loader--paused">
               <div class="dot"></div>
               <div class="outline"><span></span></div>
            </div>
            <div class="success-icon">
              <svg enable-background="new 0 0 700 700" height="700px" id="Layer_1" version="1.1" viewBox="0 0 700 700" width="200" height="200" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><circle cx="350" cy="350" fill="#ffd200" r="330"/><path
                  d="M564.385,278.229c19.137-19.135,19.137-50.162,0-69.297c-19.136-19.136-50.162-19.136-69.297,0  L294.143,409.876l-87.858-87.858c-19.136-19.135-50.161-19.135-69.297,0.001c-19.135,19.135-19.136,50.163-0.001,69.297  c0.018,0.019,0.039,0.035,0.057,0.053L271.2,525.638c12.641,12.642,33.136,12.642,45.776-0.001L564.33,278.283  C564.348,278.264,564.366,278.246,564.385,278.229z"
                  fill="#FFFFFF"/></svg>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MEASURE NOW -->
<div class="remodal remodal--action remodal--measure" data-remodal-id="measure-now" data-remodal-options="hashTracking: false" role="dialog">
  <div data-remodal-action="close" class="remodal-close" aria-label="Close">
    <?php echo $closeButtonHtml; ?>
  </div>
  <div class="remodal__content-wrapper">
    <div class="remodal__content">
      <h2 class="remodal__title">
        <span class="remodal--action__icon"></span>
        <span class="remodal--action__title">Вызов замерщика</span>
      </h2>
      <div class="remodal__description">
        Оставьте заявку и наш менеджер согласует с Вами дату и время замера
      </div>
      <div class="remodal__body">
        <div class="site-form">
          <form method="POST" action="/ajax.php">
                <input type="hidden" name="form_type" value="popup">
                <div class="form-group form-group--first">
                    <label for="user_name--measure">Имя:</label>
                    <input type="text" class="form-control required" id="user_name--measure" name="user_name--measure" placeholder="Иван Иванов">
                </div>
                <div class="form-group ">
                    <label for="user_phone--measure">Телефон:</label>
                    <input type="text" class="form-control required" id="user_phone--measure" name="user_phone--measure" placeholder="+79123456789">
                </div>
                <div class="form-group ">
                    <label for="user_question--measure">Ваш вопрос:</label>
                    <textarea class="form-control" id="user_question--measure" name="user_question--measure" placeholder="Необязательное поле" rows="5" cols="40"></textarea>
                </div>

                <button type="submit" name="submit-btn" class="btn btn--yellow btn--medium btn--action-submit">Оставить заявку</button>
            </form>
        </div>
        <div class="submit-loader submit-loader--paused">
                   <div class="dot"></div>
                   <div class="outline"><span></span></div>
        </div>
        <div class="success-icon">
          <svg enable-background="new 0 0 700 700" height="700px" id="Layer_1" version="1.1" viewBox="0 0 700 700" width="200" height="200" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><circle cx="350" cy="350" fill="#ffd200" r="330"/><path
              d="M564.385,278.229c19.137-19.135,19.137-50.162,0-69.297c-19.136-19.136-50.162-19.136-69.297,0  L294.143,409.876l-87.858-87.858c-19.136-19.135-50.161-19.135-69.297,0.001c-19.135,19.135-19.136,50.163-0.001,69.297  c0.018,0.019,0.039,0.035,0.057,0.053L271.2,525.638c12.641,12.642,33.136,12.642,45.776-0.001L564.33,278.283  C564.348,278.264,564.366,278.246,564.385,278.229z"
              fill="#FFFFFF"/></svg>
        </div>
      </div>
    </div>
  </div>
</div>
