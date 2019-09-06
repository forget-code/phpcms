Effect.SetDims = Class.create();
Object.extend(Object.extend(Effect.SetDims.prototype, Effect.Base.prototype), {
  initialize: function(element) {
    this.element = $(element)
    var options = Object.extend({
      width: 0,
      height: 0,
      duration: .5
    }, arguments[1] || {});
    this.start(options);
  },
  setup: function() {
    this.restoreAfterFinish = this.options.restoreAfterFinish || false;

    this.originalStyle = {};
    ['width','height'].each( function(k) {
      this.originalStyle[k] = this.element.style[k];
    }.bind(this));
      
    this.dims = [this.element.offsetWidth, this.element.offsetHeight];
    this.factor = [this.element.offsetWidth - this.options.width, this.element.offsetHeight - this.options.height];
  },
  update: function(position) {
    var currentScale = [this.factor[0] * position, this.factor[1] * position];
    this.setDimensions(this.dims[0] - currentScale[0], this.dims[1] - currentScale[1]);
  },
  finish: function(position) {
    if (this.restoreAfterFinish) this.element.setStyle(this.originalStyle);
  },
  setDimensions: function(width, height) {
    var d = {width: width + 'px', height: height + 'px'};
    this.element.setStyle(d);
  }
});


var PreviewToolTip = Class.create();
PreviewToolTip.prototype = {
	options: {},
	opened: true,
	
	initialize: function(element) {
		element = $(element);
		var options = Object.extend({
			element: element,
			id: 'preview_' + Math.random(),
			previewClass: 'previewWindow',
			pimpClass: 'previewPimp',
			position: 'absolute'
		}, arguments[1] || {});
		
		this.element = element;
		this.preview = document.createElement('DIV');
		this.preview.id = options.id;
		this.preview.className = options.previewClass;
		this.preview.style.position = options.position;
		
		this.pimp = document.createElement('DIV');
		this.pimp.className = options.pimpClass;
		this.pimp.onclick = (function(event){
			if (this.opened) { 
				this.hide();
			} else {
				this.show();
			};
		}).bindAsEventListener(this);
		
		this.element.appendChild(this.pimp);
		this.element.appendChild(this.preview);

		var dims = Element.getDimensions(this.pimp);
		this.options = options;
	},
	
	hide: function() {
		this.opened = false;
		var dims = Element.getDimensions(this.pimp);
		new Effect.SetDims(this.preview, {width: 0, height: 0, duration: 0.5, 
			restoreAfterFinish: true,
			afterFinish: (function() {
				this.preview.style.visibility = "hidden";
				this.pimp.style.backgroundPosition = "bottom";
			}).bind(this)
		});
	},
	
	show: function() {
		this.opened = true;
		var dims = Element.getDimensions(this.preview);
		this.preview.style.width = '0px';
		this.preview.style.height = '0px';
		this.preview.style.visibility = "visible";
		new Effect.SetDims(this.preview, {width: dims.width-6, height: dims.height-6, duration: 0.5,
			afterFinish: (function() {
				this.pimp.style.backgroundPosition = "top";
			}).bind(this)
		});
	}
};




