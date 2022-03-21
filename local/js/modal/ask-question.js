(($) => {
    Frontend.Modal = Frontend.Modal || {};

    class AskQuestion {
        static get $form() {
            return this._$form;
        }

        static set $form(value) {
            this._$form = value;
        }

        static get layoutSuccess() {
            return '' +
                '<aside class="modal modal_fix-z-index" >\n' +
                '\n' +
                '    <div class="modal-content">\n' +
                '        <div class="modal-content-close waves-effect waves-dark"></div>\n' +
                '        <div class="modal-content-header">Ваше сообщение было принято</div>\n' +
                '        \n' +
                '       <div> Большое спасибо, ваше обращение было принято.</div>\n' +
                '       <br>\n' +
                '    </div>\n' +
                '</aside>';
        }

        static get $captchaImage() {
            return this.$form.find('.modal__captcha-img_js');
        }

        static get $captchaInputHidden() {
            return this.$form.find('.modal__captcha-input-hidden_js');
        }

        static set captcha(value) {
            this._captcha = value ? true : false;
        }

        static get captcha() {
            return this._captcha === true;
        }

        static setNewCaptcha(code) {
            this.captcha = true;
        }

        static init(options) {
            let $form = $('#' + options.idElement);
            this.$form = $form;
            this.captcha = true;

            $.validator.addMethod('comment',
                (value, element) => {
                    return value.replaceAll(' ', '').length > 3
                });
            $.validator.addMethod('captcha',
                function (value, element) {
                    return this.captcha;
                }.bind(this));

            let validator = $form.validate({
                errorClass: 'validation-error text',
                // wrapper: 'label',
                errorElement: 'span',
                messages: {
                    required: 'Это поле обязательно нужно заполнить'
                },
                errorPlacement: (error, element) => {
                    element.closest('.input-field').after(error);
                }
            });

            $form.submit(function () {
                if (validator.form()) {
                    $form.ajaxSubmit({
                        data: {submit: 'Y'},
                        success: function (response) {
                            if (!response) {
                                this.showSuccess();
                            } else {
                                this.captcha = false;
                                validator.form();
                                let result = JSON.parse(response);
                                this.setNewCaptcha(result.capCode);
                            }
                        }.bind(this)
                    });
                }
                return false;
            }.bind(this));
        }

        static showSuccess() {
            this.close();
            this.$success.modal('open');
        }

        static get $success() {
            if (!this._$success) {
                this._$success = $(this.layoutSuccess).appendTo(document.body).modal();
            }
            return this._$success;
        }

        static open() {
            this.$form.closest('.modal').modal('open');
        }

        static close() {
            this.$form.closest('.modal').modal('close');
        }
    }

    Frontend.Modal.AskQuestion = AskQuestion;
})(jQuery);