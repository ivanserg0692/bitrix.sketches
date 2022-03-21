(() => {
    /**
     * NameSpace
     */
    Frontend = Frontend ? Frontend : {};
    Frontend.Modal = Frontend.Modal ? Frontend.Modal : {};

    Frontend.Modal.ProposalJuridical = class  {
        constructor() {
            const instance = this;
            this._$form = $('#form-proposal-juridical');
            this._$phone = $('.phone_js', this._$form);
            this._$form.on('submit', this.onSubmit.bind(this));
            initValidator();
            initPhoneEvents();


            function initValidator() {
            }

            function initPhoneEvents() {
                //https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html#public-methods
                instance._$phone.mask('+7 (999) 999-99-99', {
                    onComplete: function (value) {
                        instance.onFormedPhone(value);
                    },
                    onChange: instance.onResetPhone.bind(instance)
                });
            }
        }


        onFormedPhone(value) {
            this._phone = value;
        }

        onResetPhone() {
            this._phone = false;
        }
        showSuccess() {
            const successHtml = require('../../../layouts/forms/success.html');
            this._$form.html(successHtml);
            Frontend.ModalBox.updatePosition();
        }

        onSubmit() {
            if (!this._validator.form()) {
                return false;
            }
            let data = new FormData(this._$form[0]);
            $.ajax({
                url: '/local/components/main.feedback.ext/ajax.php',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        this.showSuccess();
                    } else {
                        Frontend.closeModal();
                        ANotify.error(response.error);
                    }
                }.bind(this)
            });
            return false;
        }
    }
})();
