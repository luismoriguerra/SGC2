!function($, wysi) {
	"use strict"
	
	var templates = {
		"font-styles": "<li class='dropdown'>" +
                           "<a class='btn dropdown-toggle' data-toggle='dropdown' href='#'>" +
                               "<i class='icon-font'></i>&nbsp;<span class='current-font'>Texto normal</span>&nbsp;<b class='caret'></b>" +
                           "</a>" +
                           "<ul class='dropdown-menu'>" +
                               "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='div'>Texto normal</a></li>" +
                               "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h1'>Cabecera 1</a></li>" +
                               "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h2'>Cabecera 2</a></li>" +
                           "</ul>" +
                       "</li>",
        "emphasis":    "<li>" +
                           "<div class='btn-group'>" +
                               "<a class='btn' data-wysihtml5-command='bold' title='Negrita (CTRL+B)'>N</a>" +
                               "<a class='btn' data-wysihtml5-command='italic' title='Cursiva (CTRL+I)'>K</a>" +
                               "<a class='btn' data-wysihtml5-command='underline' title='Subrayado (CTRL+U)'>S</a>" +
                           "</div>" +
                       "</li>",
        "align":
                       "<li>" +
                           "<div class='btn-group'>" +
                               "<a class='btn' data-wysihtml5-command='justifyLeft' title='Izquierda'><i class='icon-align-left'></i></a>" +
                               "<a class='btn' data-wysihtml5-command='justifyCenter' title='Centrar'><i class='icon-align-center'></i></a>" +
                               "<a class='btn' data-wysihtml5-command='justifyRight' title='Derecha'><i class='icon-align-right'></i></a>" +
                               "<a class='btn' data-wysihtml5-command='justifyJustify' title='Justificar'><i class='icon-align-justify'></i></a>" +
                           "</div>" +
                       "</li>",
        "lists":       "<li>" +
                           "<div class='btn-group'>" +
                               "<a class='btn' data-wysihtml5-command='insertUnorderedList' title='Viñetas'><i class='icon-list'></i></a>" +
                               "<a class='btn' data-wysihtml5-command='insertOrderedList' title='Numeracion'><i class='icon-th-list'></i></a>" +
                               "<a class='btn' data-wysihtml5-command='Outdent' title='Reducir sangria'><i class='icon-indent-right'></i></a>" +
                               "<a class='btn' data-wysihtml5-command='Indent' title='Aumentar sangria'><i class='icon-indent-left'></i></a>" +
                           "</div>" +
                       "</li>",
        "link":        "<li>" +
                           "<div class='bootstrap-wysihtml5-insert-link-modal modal hide fade'>" +
                               "<div class='modal-header'>" +
                                   "<a class='close' data-dismiss='modal'>&times;</a>" +
                                   /*"<h3>Insert Link</h3>" +  JC*/
                                   "<span class='t-negrita t-11'>Insertar Hipervinculo</span>" +
                               "</div>" +
                               "<div class='modal-body'>" +
                                   "<input value='http://'>" +
                               "</div>" +
                               "<div class='modal-footer'>" +
                                   "<a href='#' class='btn' data-dismiss='modal'>Cancelar</a>" +
                                   "<a href='#' class='btn btn-primary' data-dismiss='modal'>Insertar link</a>" +
                               "</div>" +
                           "</div>" +
                           "<a class='btn' data-wysihtml5-command='createLink' title='Link'><i class='icon-share'></i></a>" +
                       "</li>",
        "image":       "<li>" +
                           "<div class='bootstrap-wysihtml5-insert-image-modal modal hide fade'>" +
                               "<div class='modal-header'>" +
                                   "<a class='close' data-dismiss='modal'>&times;</a>" +
                                   /*"<h3>Insert Image</h3>" + JC*/
                                   "<span class='t-negrita t-11'>Insertar Imagen</span>" +
                               "</div>" +
                               "<div class='modal-body'>" +
                                   "<input value='http://' class='bootstrap-wysihtml5-insert-image-url input-xlarge'>" +
                               "</div>" +
                               "<div class='modal-footer'>" +
                                   "<a href='#' class='btn' data-dismiss='modal'>Cancelar</a>" +
                                   "<a href='#' class='btn btn-primary' data-dismiss='modal'>Insertar imagen</a>" +
                               "</div>" +
                           "</div>" +
                           "<a class='btn' data-wysihtml5-command='insertImage' title='Insert image'><i class='icon-picture'></i></a>" +
                       "</li>",

        "html":
                       "<li>" +
                           "<div class='btn-group'>" +
                               "<a class='btn' data-wysihtml5-action='change_view' title='Edit HTML'><i class='icon-pencil'></i></a>" +
                           "</div>" +
                       "</li>",
        /*"color":
                        "<li>" +
                          "<div>" +
                          "<a data-wysihtml5-command='foreColor' data-wysihtml5-command-value='red'>red</a> |" +
                          "<a data-wysihtml5-command='foreColor' data-wysihtml5-command-value='green'>green</a> |" +
                          "<a data-wysihtml5-command='foreColor' data-wysihtml5-command-value='blue' href='javascript:;'>blue</a> |" +
                          "</div>" +
                        "</li>"*/
        "color":
        				"<li data-wysihtml5-command-group='foreColor' class='fore-color btn' title='Color de Letra' class='command' style='padding:0px'>" +
				            "<ul>"+
				              "<li data-wysihtml5-command='foreColor' data-wysihtml5-command-value='silver'></li>"+
				              "<li data-wysihtml5-command='foreColor' data-wysihtml5-command-value='gray'></li>" +
				              "<li data-wysihtml5-command='foreColor' data-wysihtml5-command-value='maroon'></li>" +
				              "<li data-wysihtml5-command='foreColor' data-wysihtml5-command-value='red'></li>" +
				              "<li data-wysihtml5-command='foreColor' data-wysihtml5-command-value='purple'></li>" +
				              "<li data-wysihtml5-command='foreColor' data-wysihtml5-command-value='green'></li>" +
				              "<li data-wysihtml5-command='foreColor' data-wysihtml5-command-value='olive'></li>" +
				              "<li data-wysihtml5-command='foreColor' data-wysihtml5-command-value='navy'></li>" +
				              "<li data-wysihtml5-command='foreColor' data-wysihtml5-command-value='blue'></li>" +
				            "</ul>" +
				        "</li>"
	};
	
	var defaultOptions = {
		"font-styles": true,
		"emphasis": true,
		"align":true,
		"lists": true,
		"color":true,
		"html": false,
		"link": false,
		"image": false,
		events: {},
		parserRules: {
			"classes": {
                "wysiwyg-clear-both": 1,
                "wysiwyg-clear-left": 1,
                "wysiwyg-clear-right": 1,
                "wysiwyg-color-aqua": 1,
                "wysiwyg-color-black": 1,
                "wysiwyg-color-blue": 1,
                "wysiwyg-color-fuchsia": 1,
                "wysiwyg-color-gray": 1,
                "wysiwyg-color-green": 1,
                "wysiwyg-color-lime": 1,
                "wysiwyg-color-maroon": 1,
                "wysiwyg-color-navy": 1,
                "wysiwyg-color-olive": 1,
                "wysiwyg-color-purple": 1,
                "wysiwyg-color-red": 1,
                "wysiwyg-color-silver": 1,
                "wysiwyg-color-teal": 1,
                "wysiwyg-color-white": 1,
                "wysiwyg-color-yellow": 1,
                "wysiwyg-float-left": 1,
                "wysiwyg-float-right": 1,
                "wysiwyg-font-size-large": 1,
                "wysiwyg-font-size-larger": 1,
                "wysiwyg-font-size-medium": 1,
                "wysiwyg-font-size-small": 1,
                "wysiwyg-font-size-smaller": 1,
                "wysiwyg-font-size-x-large": 1,
                "wysiwyg-font-size-x-small": 1,
                "wysiwyg-font-size-xx-large": 1,
                "wysiwyg-font-size-xx-small": 1,
                "wysiwyg-text-align-center": 1,
                "wysiwyg-text-align-justify": 1,
                "wysiwyg-text-align-left": 1,
                "wysiwyg-text-align-right": 1
            },
			tags: {
				"b":  {},
				"i":  {},
				"br": {},
				"ol": {},
				"ul": {},
				"li": {},
				"h1": {},
				"h2": {},
				"u": 1,
				"img": {
					"check_attributes": {
			            "width": "numbers",
			            "alt": "alt",
			            "src": "url",
			            "height": "numbers"
			        }
				},
				"a":  {
					set_attributes: {
						target: "_blank",
						rel:    "nofollow"
					},
					check_attributes: {
						href:   "url" // important to avoid XSS
					}
				},
				"div": 1
			}
		}
	};

	var Wysihtml5 = function(el, options) {
		this.el = el;
		this.toolbar = this.createToolbar(el, options || defaultOptions);
		this.editor =  this.createEditor(options);
		
		window.editor = this.editor;

  		$('iframe.wysihtml5-sandbox').each(function(i, el){
			$(el.contentWindow).off('focus.wysihtml5').on({
			  'focus.wysihtml5' : function(){
			     $('li.dropdown').removeClass('open');
			   }
			});
		});
	};

	Wysihtml5.prototype = {
		constructor: Wysihtml5,

		createEditor: function(options) {
			var parserRules = defaultOptions.parserRules; 

			if(options && options.parserRules) {
				parserRules = options.parserRules;
			}
				
			var editor = new wysi.Editor(this.el.attr('id'), {
	    		toolbar: this.toolbar.attr('id'),
	    		stylesheets: "../javascript/includes/wysihtml5bootstrat/lib/css/stylesheet.css",
				parserRules: parserRules
	  		});

	  		if(options && options.events) {
				for(var eventName in options.events) {
					editor.on(eventName, options.events[eventName]);
				}
			}	

	  		return editor;
		},
		
		createToolbar: function(el, options) {
			var self = this;
			var toolbar = $("<ul/>", {
				'id' : el.attr('id') + "-wysihtml5-toolbar",
				'class' : "wysihtml5-toolbar",
				'style': "display:none"
			});

			for(var key in defaultOptions) {
				var value = false;
				
				if(options[key] != undefined) {
					if(options[key] == true) {
						value = true;
					}
				} else {
					value = defaultOptions[key];
				}
				
				if(value == true) {
					toolbar.append(templates[key]);

					if(key == "html") {
						this.initHtml(toolbar);
					}

					if(key == "link") {
						this.initInsertLink(toolbar);
					}

					if(key == "image") {
						this.initInsertImage(toolbar);
					}
				}
			}
			
			var self = this;
			
			toolbar.find("a[data-wysihtml5-command='formatBlock']").click(function(e) {
				var el = $(e.srcElement);
				self.toolbar.find('.current-font').text(el.html())
			});
			
			this.el.before(toolbar);
			
			return toolbar;
		},

		initHtml: function(toolbar) {
			var changeViewSelector = "a[data-wysihtml5-action='change_view']";
			toolbar.find(changeViewSelector).click(function(e) {
				toolbar.find('a.btn').not(changeViewSelector).toggleClass('disabled');
			});
		},

		initInsertImage: function(toolbar) {
			var self = this;
			var insertImageModal = toolbar.find('.bootstrap-wysihtml5-insert-image-modal');
			var urlInput = insertImageModal.find('.bootstrap-wysihtml5-insert-image-url');
			var insertButton = insertImageModal.find('a.btn-primary');
			var initialValue = urlInput.val();

			var insertImage = function() { 
				var url = urlInput.val();
				urlInput.val(initialValue);
				self.editor.composer.commands.exec("insertImage", url);
			};
			
			urlInput.keypress(function(e) {
				if(e.which == 13) {
					insertImage();
					insertImageModal.modal('hide');
				}
			});

			insertButton.click(insertImage);

			insertImageModal.on('shown', function() {
				urlInput.focus();
			});

			insertImageModal.on('hide', function() { 
				self.editor.currentView.element.focus();
			});

			toolbar.find('a[data-wysihtml5-command=insertImage]').click(function() {
				insertImageModal.modal('show');
			});
		},

		initInsertLink: function(toolbar) {
			var self = this;
			var insertLinkModal = toolbar.find('.bootstrap-wysihtml5-insert-link-modal');
			var urlInput = insertLinkModal.find('.bootstrap-wysihtml5-insert-link-url');
			var insertButton = insertLinkModal.find('a.btn-primary');
			var initialValue = urlInput.val();

			var insertLink = function() { 
				var url = urlInput.val();
				urlInput.val(initialValue);
				self.editor.composer.commands.exec("createLink", { 
					href: url, 
					target: "_blank", 
					rel: "nofollow" 
				});
			};
			var pressedEnter = false;

			urlInput.keypress(function(e) {
				if(e.which == 13) {
					insertLink();
					insertLinkModal.modal('hide');
				}
			});

			insertButton.click(insertLink);

			insertLinkModal.on('shown', function() {
				urlInput.focus();
			});

			insertLinkModal.on('hide', function() { 
				self.editor.currentView.element.focus();
			});

			toolbar.find('a[data-wysihtml5-command=createLink]').click(function() {
				insertLinkModal.modal('show');
			});
		}
	};

	$.fn.wysihtml5 = function (options) {
		return this.each(function () {
			var $this = $(this);
	      	$this.data('wysihtml5', new Wysihtml5($this, options));
	    })
  	};

  	$.fn.wysihtml5.Constructor = Wysihtml5;

}(window.jQuery, window.wysihtml5);
