(function() {
    tinymce.PluginManager.add('idp_slider_lite_shortcodes', function( editor, url ) { // id кнопки true_mce_button должен быть везде один и тот же
        editor.addButton( 'idp_slider_lite_shortcodes', { // id кнопки true_mce_button
            text: 'IDP Sliders lite',
            icon: false, // мой собственный CSS класс, благодаря которому я задам иконку кнопки
            type: 'menubutton',
            title: 'Insert slider shortcoder', // всплывающая подсказка при наведении
            menu: [ // тут начинается первый выпадающий список
                {//1-элемент
                    text: 'Modern-lite slider',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Modern-lite slider with caption text',
                            body: [
                                {
                                    type: 'textbox', // тип textbox = текстовое поле
                                    name: 'ids', // ID, будет использоваться ниже
                                    label: 'ID slider', // лейбл
                                    value: '1' // значение по умолчанию
                                }
                            ],
                            onsubmit: function( e ) { // это будет происходить после заполнения полей и нажатии кнопки отправки
                                editor.insertContent( '[Modern-lite ids="' + e.data.ids + '"]');
                            }
                        });
                    }
                }//end slider
            ]
        });
    });
})();