// MH SHORTCODES TinyMCE 1.0
// =============================================================================

(function () {
    'use strict';
    var width = jQuery(window).width(),
        checkHeight = jQuery(window).height(),
        checkWidth = (800 < width) ? 800 : width,
        tiWidth = checkWidth - 110,
        tiHeight = checkHeight - 110;

    tinymce.PluginManager.add('mhsc_shortcodes', function (editor, url) {

        editor.addButton('mhsc_shortcodes_button', {

            type: 'menubutton',
            title: 'MH Shortcodes',
            text: '',
            image: url + '/mhsc_shortcodes.png',
           // style: 'background-image: url("' + url + '/mhsc_shortcodes.png' + '"); background-repeat: no-repeat; background-position: center center;"',
            //icon: true,
            menu: [
            {
                text: 'Button',
                onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: 'Add Button',
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'buttonhref',
                                            label: 'URL',
                                            value: '#'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'buttoncontent',
                                            label: 'Button Text',
                                            value: 'Click me!'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'buttontitle',
                                            label: 'HTML Title',
                                            //tooltip: 'Button Title'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'buttoncolor',
											maxWidth: 100,
                                            label: 'Colour',
                                            value: '#e84533'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'buttontxcolor',
                                            label: 'Colour',
                                            value: '#ffffff'
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'buttontarget',
                                            maxWidth: 250,
                                            label: 'State',
                                            'values': [
                                                {
                                                    text: 'Open link in same window',
                                                    value: 'self'
                                                },
                                                {
                                                    text: 'Open link in new window',
                                                    value: 'blank'
                                                }
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'buttonshape',
                                            maxWidth: 150,
                                            label: 'Style',
                                            'values': [
                                                {
                                                    text: 'Solid',
                                                    value: 'solidify'
                                                },
                                                {
                                                    text:'Transparent',
                                                    value: 'transify'
                                                }
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'buttonsize',
                                            maxWidth: 150,
                                            label: 'Size',
                                            'values': [
                                                {
                                                    text: 'Default',
                                                    value: 'x2'
                                                },
                                                {
                                                    text: 'Small',
                                                    value: 'x1'
                                                },
                                                {
                                                    text: 'Large',
                                                    value: 'x3'
                                                }
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'buttonfwidth',
											maxWidth: 150,
                                            label: 'Full Width',
                                            'values': [
                                                {
                                                    text: 'No',
                                                    value: 'false'
                                                },
                                                {
                                                    text: 'Yes',
                                                    value: 'true'
                                                }
                                            ]
                                        }
                                    ],
                                    onsubmit: function (e) {
                                        editor.insertContent('[button href="' + e.data.buttonhref + '" title="' + e.data.buttontitle + '" target="' + e.data.buttontarget + '" shape="' + e.data.buttonshape + '" size="' + e.data.buttonsize + '" txcolor="' + e.data.buttontxcolor + '" color="' + e.data.buttoncolor + '" fullwidth="' + e.data.buttonfwidth + '"]' + e.data.buttoncontent + '[/button]');
                                    }
                                });
                            }
            }, //end Buttons
                {
                       text: 'Maker',
                            onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: 'Marker',
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'markercontnet',
                                            label: 'Content',
                                            value: 'Content goes here',
                                            multiline: true,
                                            minWidth: 200,
                                            minHeight: 100
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'markercolor',
                                            maxWidth: 150,
                                            label: 'Colour',
                                            'values': [
                                                {
                                                    text: 'Yellow',
                                                    value: '#FFFA4A'
                                                },
                                                {
                                                    text: 'Green',
                                                    value: '#C3FF5A'
                                                },
                                                {
                                                    text: 'Pink',
                                                    value: '#FF7BFF'
                                                },
                                                {
                                                    text: 'Orange',
                                                    value: '#FFC440'
                                                },
                                                {
                                                    text: 'Dark',
                                                    value: '#444444'
                                                }
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'markertxcolor',
											maxWidth: 150,
                                            label: 'Colour',
                                            'values': [
                                                {
                                                    text: 'Dark',
                                                    value: 'dark'
                                                },
                                                {
                                                    text: 'Light',
                                                    value: 'light'
                                                }
                                            ]
                                        }
                                    ],
                                    onsubmit: function (e) {
                                        editor.insertContent('[marker color="' + e.data.markercolor + '"  txcolor="' + e.data.markertxcolor + '"  style="" id="" class=""]' + e.data.markercontnet + '[/marker]');
                                    }
                                });
                            }
                }, //marker
                {
    text: 'Text Box',
                            onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: 'Text Box',
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'alerthead',
                                            label: 'Title',
                                            value: 'Content goes here'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'alertcontnet',
                                            label: 'Text Box',
                                            value: 'Content goes here',
                                            multiline: true,
                                            minWidth: 200,
                                            minHeight: 200
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'alertcolor',
											maxWidth: 150,
                                            label: 'Colour',
                                            'values': [
                                                {
                                                    text: 'Green',
                                                    value: '#2ecc71'
                                                },
                                                {
                                                    text: 'Red',
                                                    value: '#eb5439'
                                                },
                                                {
                                                    text: 'Blue',
                                                    value: '#4d8fcb'
                                                },
                                                {
                                                    text: 'Yellow',
                                                    value: '#fab418'
                                                },
                                                {
                                                    text: 'Gray',
                                                    value: '#999'
                                                }

                                            ]
                                        },
                                        {
                                            type: 'checkbox',
                                            name: 'alertclose',
                                            checked: true,
                                            text: 'Show Close Button'
                                        }
                                    ],
                                    onsubmit: function (e) {
                                        editor.insertContent('[alert heading="' + e.data.alerthead + '" color="' + e.data.alertcolor + '"  close="' + e.data.alertclose + '" style="" id="" class=""]' + e.data.alertcontnet + '[/alert]');
                                    }
                                });
                                }
                },//alert boxes
                {
                       text: 'Divider',
                            onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: 'Divider',
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'separatorsize',
                                            label: 'Size',
                                            value: '3',
                                            tooltip: 'Divider thickness in pixels. Numeric value only.',
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'separatorcolor',
                                            label: 'Colour',
                                            tooltip: 'If you would like a transparent divider Leave this field empty, or input your desired colour here e.g. #333333',
                                        }
                                    ],
                                    onsubmit: function (e) {
                                        editor.insertContent('[separator size="' + e.data.separatorsize + '"  color="' + e.data.separatorcolor + '"  style="" id="" class=""]');
                                    }
                                });
                            }
                                        }, //end separator
                {
                                text: 'Link',
                            onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: 'Add Link',
                                   body: [
                                        {
                                            type: 'textbox',
                                            name: 'linkhref',
                                            label: 'URL',
                                            value: '#'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'linkcontent',
                                            label: 'Link Texte',
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'linktitle',
                                            label: 'Link Title',
                                           // tooltip: 'Button Title'
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'linktarget',
                                            maxWidth: 250,
                                            label: 'State',
                                            'values': [
                                                {
                                                    text: 'Open link in same window',
                                                    value: 'self'
                                                },
                                                {
                                                    text: 'Open link in new window',
                                                    value: 'blank'
                                                }
                                            ]
                                        }
                                                 
                                    ],
                                    onsubmit: function (e) {
                                        editor.insertContent('[link href="' + e.data.linkhref + '" title="' + e.data.linktitle + '" target="' + e.data.linktarget + '"]' + e.data.linkcontent + '[/link]');
                                    }
                                });
                            }
                                        }, //end link
                                        {
                            text: 'Clearfix',
                            onclick: function () {
                                editor.insertContent('[clearfix]');
                            }, //end clearfix
                                        }
                    ] //menu

        });
                            

    });

})();