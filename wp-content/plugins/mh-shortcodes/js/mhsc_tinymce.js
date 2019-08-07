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
            title: editor.getLang('mhtinylang.mhsc-title'),
            text: '',
            image: url + '/mhsc_shortcodes.png',
           // style: 'background-image: url("' + url + '/mhsc_shortcodes.png' + '"); background-repeat: no-repeat; background-position: center center;"',
            //icon: true,
            menu: [
            {
                text: editor.getLang('mhtinylang.button'),
                onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: editor.getLang('mhtinylang.addbutton'),
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'buttonhref',
                                            label: editor.getLang('mhtinylang.href'),
                                            value: '#'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'buttoncontent',
                                            label: editor.getLang('mhtinylang.button_text'),
                                            value: editor.getLang('mhtinylang.exabtn')
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'buttontitle',
                                            label: editor.getLang('mhtinylang.btntitle'),
                                            tooltip: editor.getLang('mhtinylang.tip-btntitle')
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'buttoncolor',
											maxWidth: 100,
                                            label: editor.getLang('mhtinylang.color'),
                                            value: '#e84533'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'buttontxcolor',
                                            label: editor.getLang('mhtinylang.txcolor'),
                                            value: '#ffffff'
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'buttontarget',
                                            maxWidth: 150,
                                            label: editor.getLang('mhtinylang.target'),
                                            'values': [
                                                {
                                                    text: editor.getLang('mhtinylang.self'),
                                                    value: 'self'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.blank'),
                                                    value: 'blank'
                                                }
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'buttonshape',
                                            maxWidth: 150,
                                            label: editor.getLang('mhtinylang.shape'),
                                            'values': [
                                                {
                                                    text: editor.getLang('mhtinylang.fullcolor'),
                                                    value: 'solidify'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.transparent'),
                                                    value: 'transify'
                                                }
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'buttonsize',
                                            maxWidth: 150,
                                            label: editor.getLang('mhtinylang.size'),
                                            'values': [
                                                {
                                                    text: editor.getLang('mhtinylang.regular'),
                                                    value: 'x2'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.small'),
                                                    value: 'x1'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.large'),
                                                    value: 'x3'
                                                }
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'buttonfwidth',
																						maxWidth: 150,
                                            label: editor.getLang('mhtinylang.fwidth'),
                                            'values': [
                                                {
                                                    text: editor.getLang('mhtinylang.false'),
                                                    value: 'false'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.true'),
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
                       text: editor.getLang('mhtinylang.marker'),
                            onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: editor.getLang('mhtinylang.marker'),
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'markercontnet',
                                            label: editor.getLang('mhtinylang.text'),
                                            value: editor.getLang('mhtinylang.exa'),
                                            multiline: true,
                                            minWidth: 200,
                                            minHeight: 100
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'markercolor',
                                            maxWidth: 150,
                                            label: editor.getLang('mhtinylang.color'),
                                            'values': [
                                                {
                                                    text: editor.getLang('mhtinylang.yellow'),
                                                    value: '#FFFA4A'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.green'),
                                                    value: '#C3FF5A'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.pink'),
                                                    value: '#FF7BFF'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.orange'),
                                                    value: '#FFC440'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.dark'),
                                                    value: '#444444'
                                                }
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'markertxcolor',
																						maxWidth: 150,
                                            label: editor.getLang('mhtinylang.txcolor'),
                                            'values': [
                                                {
                                                    text: editor.getLang('mhtinylang.dark'),
                                                    value: 'dark'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.light'),
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
    text: editor.getLang('mhtinylang.alert'),
                            onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: editor.getLang('mhtinylang.alert'),
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'alerthead',
                                            label: editor.getLang('mhtinylang.title'),
                                            value: editor.getLang('mhtinylang.exa')
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'alertcontnet',
                                            label: editor.getLang('mhtinylang.alert'),
                                            value: editor.getLang('mhtinylang.exa'),
                                            multiline: true,
                                            minWidth: 200,
                                            minHeight: 200
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'alertcolor',
																						maxWidth: 150,
                                            label: editor.getLang('mhtinylang.color'),
                                            'values': [
                                                {
                                                    text: editor.getLang('mhtinylang.green'),
                                                    value: '#2ecc71'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.red'),
                                                    value: '#eb5439'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.blue'),
                                                    value: '#4d8fcb'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.yellow'),
                                                    value: '#fab418'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.gray'),
                                                    value: '#999'
                                                }

                                            ]
                                        },
                                        {
                                            type: 'checkbox',
                                            name: 'alertclose',
                                            checked: true,
                                            text: editor.getLang('mhtinylang.showclose')
                                        }
                                    ],
                                    onsubmit: function (e) {
                                        editor.insertContent('[alert heading="' + e.data.alerthead + '" color="' + e.data.alertcolor + '"  close="' + e.data.alertclose + '" style="" id="" class=""]' + e.data.alertcontnet + '[/alert]');
                                    }
                                });
                                }
                },//alert boxes
                {
                       text: editor.getLang('mhtinylang.separator'),
                            onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: editor.getLang('mhtinylang.separator'),
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'separatorsize',
                                            label: editor.getLang('mhtinylang.size'),
                                            value: '3',
                                            tooltip: editor.getLang('mhtinylang.tip-separator01'),
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'separatorcolor',
                                            label: editor.getLang('mhtinylang.color'),
                                            tooltip: editor.getLang('mhtinylang.tip-separator02'),
                                        }
                                    ],
                                    onsubmit: function (e) {
                                        editor.insertContent('[separator size="' + e.data.separatorsize + '"  color="' + e.data.separatorcolor + '"  style="" id="" class=""]');
                                    }
                                });
                            }
                                        }, //end separator
                {
                                text: editor.getLang('mhtinylang.link'),
                            onclick: function () {
                                editor.windowManager.open({
                                    width: tiWidth,
                                    height: tiHeight,
                                    title: editor.getLang('mhtinylang.addlink'),
                                   body: [
                                        {
                                            type: 'textbox',
                                            name: 'linkhref',
                                            label: editor.getLang('mhtinylang.href'),
                                            value: '#'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'linkcontent',
                                            label: editor.getLang('mhtinylang.link_text'),
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'linktitle',
                                            label: editor.getLang('mhtinylang.linktitle'),
                                            tooltip: editor.getLang('mhtinylang.tip-btntitle')
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'linktarget',
                                            maxWidth: 150,
                                            label: editor.getLang('mhtinylang.target'),
                                            'values': [
                                                {
                                                    text: editor.getLang('mhtinylang.self'),
                                                    value: 'self'
                                                },
                                                {
                                                    text: editor.getLang('mhtinylang.blank'),
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
                            text: editor.getLang('mhtinylang.clearfix'),
                            onclick: function () {
                                editor.insertContent('[clearfix]');
                            }, //end clearfix
                                        }
                    ] //menu

        });
                            

    });

})();