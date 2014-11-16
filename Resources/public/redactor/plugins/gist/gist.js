if (!RedactorPlugins) var RedactorPlugins = {};

RedactorPlugins.gist = function () {
    return {
        // Get modal template
        getTemplate: function () {
            return String()
            + '<section id="redactor-modal-gist-insert">'
                + '<label>' + this.lang.get('web') + '</label>'
                + '<input type="url" id="redactor-insert-gist-url" />'
            + '</section>';
        },

        // Return Gist html code
        getHtml: function () {
            return String()
            + '<p class="github-gist">'
                + '<span style="display:none">gist:' + $.trim(this.gist.$url.val()) + '</span>'
                + '<scr' + 'ipt type="text/javascript" src="' + $.trim(this.gist.$url.val()) + '"></script>'
            + '</p>';
        },

        // Init plugin
        init: function () {
            var button = this.button.addAfter('link', 'gist', this.lang.get('gist'));
            this.button.addCallback(button, this.gist.show);
        },

        // Show modal with 3 buttons: cancel, insert & create (open new tab on https://gist.github.com/)
        show: function () {
            this.modal.addTemplate('gist', this.gist.getTemplate());
            this.modal.load('gist', this.lang.get('gist'), 600);

            // Add `Cancel` button
            this.modal.createCancelButton();

            // Add `Insert` button
            var button = this.modal.createActionButton(this.lang.get('insert'));
            button.on('click', this.gist.insert);

            // Add `Create Gist` button
            var create = this.modal.createButton(this.lang.get('gist_create'), 'gist');
            create.on('click', function () {
                window.open('https://gist.github.com/');
            });

            // Inject selection into input field
            this.selection.get();
            this.gist.$url = $('#redactor-insert-gist-url');
            this.gist.$url.val($.trim(this.sel.toString()));

            // Show modal
            this.selection.save();
            this.modal.show();
            this.gist.$url.focus();
        },

        // Insert html code
        insert: function () {
            var url = this.gist.$url.val();

            // Check if field is filled
            if ($.trim(url) === '') {
                // Show error on input field
                this.gist.$url.addClass('redactor-input-error').on('keyup', function () {
                    $(this).removeClass('redactor-input-error');
                    $(this).off('keyup');
                });
            }

            // Replace selection by html code
            this.selection.restore();
            $(this.selection.getCurrent()).html(this.gist.getHtml());

            this.code.sync();

            // Callback
            this.core.setCallback('insertedGist', $(this.selection.getCurrent()).children().first());

            this.modal.close();
        }
    };
};
