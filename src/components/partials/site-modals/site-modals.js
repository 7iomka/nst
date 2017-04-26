// validation library
import 'jquery-validation';
// custom validator settings
import 'vendors/jquery.validator-custom';

import 'jquery.inputmask';
// Add extensions as necessary make sure you remember to add the corresponding aliases in the webpack config
import 'inputmask.numeric.extensions';

domready(function () {
  exports.init = function () {
    /********************************** SETTINGS FOR ALL FORMS in MODAL *************************************/
    var $actionModal = $('.action-modal');

    $actionModal.each(function() {
        var $this = $(this),
            $form = $(this).find('.form'),
            $action_id = $this.attr('id');

        // предотвращаем отправку формы
        $form.submit(function(e) {
            e.preventDefault();
        });

        var rules = {},
            messages = {};

        var namespaces = ["user_name", "user_phone", "user_email"];

        $.each(namespaces, function(i, namespace) {
            var $form_elements = $form.find('input[name^="' + namespace + '"], textarea[name^="' + namespace + '"]');

            $form_elements.each(function() {
                var elem_name = $(this).attr('name');
                var message;

                switch (namespace) {
                    case "user_name":
                        message = "Заполните Ваше имя";
                        break;
                    case "user_phone":
                        message = "Не указан телефон";
                        break;
                    case "user_email":
                        message = "Укажите корректный email";
                        break;
                    default:
                        message = "Заполните данное поле";
                        break;
                }
                rules[elem_name] = {
                    required: !$(this).hasClass('optional')
                };
                if (namespace === 'user_phone') {
                    $('input[name^="' + namespace + '"]').inputmask("+7 (999) 999-9999");
                    rules[elem_name].usPhoneFormat = true;
                }

                if (namespace === 'user_email') {
                  rules[elem_name].email = (namespace === 'user_email');
                }
                messages[elem_name] = {
                    required: message
                }

            });

        })
        // console.log(rules, messages);
        $form.validate({
            rules: rules,
            messages: messages,
            highlight: function (element) {
               $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
               $(element).removeClass('form-control-success').addClass('form-control-danger');
             },
             unhighlight: function (element) {
                 $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                 $(element).removeClass('form-control-danger').addClass('form-control-success');

             },
           errorClass: 'form-control-feedback',
           errorPlacement: function (error, element) {
               if (element.parent('.input-group').length) {
                   error.insertAfter(element.parent());
               } else {
                   error.insertAfter(element);
               }
           },
            submitHandler: function(form) {
                submitModalForm(form, $action_id);
            }
        });

    });
    function submitModalForm(form, task) {
        // форма
        var $form = $(form);

        // в какой модалке находится
        var $formModal = $form.closest('.action-modal');


        // значения элементов формы
        // var name            = $form.find("#user_name--order").val();
        // var phone           = $form.find("#user_phone--order").val();
        // var email           = $form.find("#user_email--order").val();
        // var comments        = $form.find("#user_comments--order").val();

        // прочие элементы контейнера
        var $modalTitle            = $formModal.find('.action-modal__title');
        var $modalContent          = $formModal.find('.action-modal__content');
        var $modalAnnonce          = $formModal.find('.action-modal__annonce');

        var $modalPrimaryContainer = $formModal.find('.primary-container');

        var $modalPreloader        = $formModal.find('.preloader');

        var $modalSuccessContainer = $formModal.find('.success-container');

        var $modalResetButton      = $formModal.find('.modal__button-close');
        var $finalData             = $modalSuccessContainer.find('.final-data');

        // время анимации при переключении видимости контейнеров
        var sendTransitionTime = 400;




        // Хешируем перезаписываемые элементы контейнера модалки
        var primaryData = {
          $modalTitle: $modalTitle.html(),
          $modalAnnonce: $modalAnnonce.html(),
          primaryContentHeight: false
        };







        /*  prepare serialized array for the addition of a form type identifier  */
        var form_data = $(form).serializeArray();
        // for php data
        form_data.push({name: "task", value: task});
        form_data = $.param(form_data);

        // для заказа делаем свои закономерности в calculator-functions.js
        if (task === 'action-order') {

            sendOrder();
            // return;
        } else {
          // для всех остальных модалок
            $.ajax({
                url: localProxy + '/ajax.php',
                type: 'POST',
                data: form_data,

                beforeSend: function(r) {
                    // $form.hide();
                    // $modalTitle.html('Отправка заявки...');
                    // $modalAnnonce.html('');
                    // **************************

                    // Получаем высоту первоначального контента (формы) и фиксируем её у родителя
                    // для последующей анимации до высоты результирующего контейнера
                    var primaryContentHeight = $modalPrimaryContainer.outerHeight();
                    // сохраняем значение
                    primaryData.primaryContentHeight = primaryContentHeight;

                    $modalContent.css('height', primaryContentHeight);

                    // промежуточный заголовок
                    $modalTitle.html('Идет отправка...');
                    // скрываем котнейнер с формой
                    $modalPrimaryContainer.fadeOut(sendTransitionTime, function(){
                      // включаем прелоадер
                      $modalPreloader.fadeIn();
                      // тут выполняем действия в результате полученного аякс-ответа
                    });

                }
            }).always(function(r) {

            }).done(function(r) {

                // последние действия
                function finalActions(){

                  // обновляем заголовок
                  $modalTitle.text('Ваша заявка оформлена');


                  // получаем высоты контента контейнера с успешными данными о заявке
                  var modalSuccessContainerHeight = $finalData.actualHeight(true);
                  // анимируем контейнер до вычисленной высоты
                  $modalContent.smoothAnimate({
                    height: modalSuccessContainerHeight
                  },{
                      duration: 600,
                      easing: 'ease',
                      complete: function () {
                          // скрываем прелоадер
                          $modalPreloader.fadeOut();
                          // убираем статичную высоту
                          $modalContent.css('height', 'auto');
                          // отображаем данные о заявке
                          $finalData.fadeIn();

                      }
                  })
                }
                // выполняем эти действия не раньше чем скроется первоначальный контейнер
                setTimeout(finalActions, sendTransitionTime);

                // действия сброса формы
                function resetDataActions() {
                  // ресетим форму
                  $form.trigger('reset');
                  // удаляем все классы с полей по отношению к заполненности
                  $form.find('.form-group').removeClass('has-success has-danger');
                  $form.find('.form-control').removeClass('form-control-success form-control-danger');

                  // обновляем заголовок
                  $modalTitle.html(primaryData.$modalTitle);
                  $modalAnnonce.html(primaryData.$modalAnnonce);

                  /**
                   * Простой сброс формы (сброс данных в фоне)
                   */

                   // скрываем данные о заявке
                   $finalData.fadeOut(sendTransitionTime);
                   $modalPrimaryContainer.fadeIn(sendTransitionTime);

                  /**
                   * Красивый сброс формы (не актуален)
                   */
                  /*
                     // включаем прелоадер
                      $modalPreloader.fadeIn(sendTransitionTime);
                      // скрываем данные о заявке
                      $finalData.fadeOut(sendTransitionTime);

                      var primaryContentHeight = primaryData.primaryContentHeight || $modalPrimaryContainer.outerHeight();

                      // $modalContent.css('height', primaryContentHeight);
                      $modalContent.smoothAnimate({
                        height: primaryContentHeight
                      },{
                          duration: 600,
                          easing: 'ease',
                          complete: function () {
                            // выключаем прелоадер
                            $modalPreloader.fadeOut();
                            // показываем котнейнер с формой
                            $modalPrimaryContainer.fadeIn(sendTransitionTime, function(){
                              // убираем статичную высоту
                              $modalContent.css('height', 'auto');
                            });
                          }
                      });
                    */


                }


                // вешаем событие преждевременного одноразового сброса на кнопку возврата к сайту
                $modalResetButton.one('click', function () {
                  resetDataActions();
                });

                $(document).one('afterClose.fb', function( e, instance, slide ) {

                  var $modalSource = $(instance.current.src);
                  if ($modalSource.is($formModal)) {
                    resetDataActions();
                    console.log('eeeeee')
                  }
                });


            }).fail(function(request, textStatus, errorThrown) {
                // alert('fail');
                console.log(request.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            });

        } // end else

    };


  }
});
