(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
( function( $ ) {
	'use strict';

	var MHComposerGutenbergApp = {

		cacheElements: function() {
			this.MHComposerisActive = '1' === MHComposerGutenbergSettings.MHComposerisActive;

			this.cache = {};

			this.cache.$gutenberg = $( '#editor' );
			this.cache.$switchMode = $( $( '#mhcomposer-gutenberg-button-switch-mode' ).html() );

			this.cache.$gutenberg.find( '.edit-post-header-toolbar' ).append( this.cache.$switchMode );
			this.cache.$switchModeButton = this.cache.$switchMode.find( '#mhcomposer-switch-mode-button' );

			this.toggleStatus();
			this.buildPanel();

			var self = this;

			wp.data.subscribe( function() {
				setTimeout( function() {
					self.buildPanel();
				}, 1 );
			} );
		},

		buildPanel: function() {
			var self = this;

			if ( ! $( '#mhcomposer-editor' ).length ) {
				self.cache.$editorPanel = $( $( '#mhcomposer-gutenberg-panel' ).html() );
				self.cache.$gurenbergBlockList = self.cache.$gutenberg.find( '.editor-block-list__layout, .editor-post-text-editor' );
				self.cache.$gurenbergBlockList.after( self.cache.$editorPanel );

				self.cache.$editorPanelButton = self.cache.$editorPanel.find( '#mhcomposer-go-to-edit-page-link' );

				self.cache.$editorPanelButton.on( 'click', function( event ) {
					event.preventDefault();

					self.animateLoader();

					var documentTitle = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'title' ),
                        customTitle = MHComposerGutenbergSettings.PageDraftTitle;
					if ( ! documentTitle ) {
						wp.data.dispatch( 'core/editor' ).editPost( { title: customTitle + $( '#post_ID' ).val() } );
					}

					wp.data.dispatch( 'core/editor' ).savePost();
					self.redirectWhenSave();
				} );
			}
		},

		bindEvents: function() {
			var self = this;

			self.cache.$switchModeButton.on( 'click', function() {
				self.MHComposerisActive = ! self.MHComposerisActive;

				self.toggleStatus();

				if ( self.MHComposerisActive ) {
					self.cache.$editorPanelButton.trigger( 'click' );
				} else {
					var wpEditor = wp.data.dispatch( 'core/editor' );

					wpEditor.editPost( { gutenberg_mhcomposer_mode: false } );
					wpEditor.savePost();
				}
			} );
		},

		redirectWhenSave: function() {
			var self = this;

			setTimeout( function() {
				if ( wp.data.select( 'core/editor' ).isSavingPost() ) {
					self.redirectWhenSave();
				} else {
					location.href = MHComposerGutenbergSettings.EditURL;
				}
			}, 300 );
		},

		animateLoader: function() {
			this.cache.$editorPanelButton.addClass( 'mhcomposer-animate' );
		},

		toggleStatus: function() {
			jQuery( 'body' )
				.toggleClass( 'mhcomposer-editor-active', this.MHComposerisActive )
				.toggleClass( 'mhcomposer-editor-inactive', ! this.MHComposerisActive );
		},

		init: function() {
			var self = this;
			setTimeout( function() {
				self.cacheElements();
				self.bindEvents();
			}, 1 );
		}
	};

	$( function() {
		MHComposerGutenbergApp.init();
	} );

}( jQuery ) );

},{}]},{},[1])