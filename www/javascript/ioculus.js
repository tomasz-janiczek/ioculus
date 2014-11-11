Object.extend(Object, {
	getClass : function(obj)
	{
		if (obj && obj.constructor && obj.constructor.toString)
		{
			var arr = obj.constructor.toString().match(/function\s*(\w+)/);
			if (arr && arr.length == 2) return arr[1];
		}

		return undefined;
	}
});

Object.extend(Array.prototype, {
	implode : function(separator)
	{
		var str = '';
		
		if (!separator) separator = ' ';

		this.each(function(pos) {		
			if (str) str += separator;
			str += pos;
		});
		
		return str;
	}
});

/* implodeCheckboxes(form, checked)
 *
 * Gets all checkboxes from a given form object and 'implodes' their values.
 *
 * Example output of Form.implodeCheckboxes(form): "1,2,3,5,10,13,24,45,46,47"
 *
 */
 
Object.extend(Form, {
	implodeCheckboxes : function(obj, checked)
	{
		var checked = (checked == null) ? true : checked;
		var list = Form.getInputs(obj, "checkbox");
		var ids = "";
		
		for (var i = 0;i < list.length;i++)
		{
			if (checked && !list[i].checked) continue;
			
			if (ids) ids += ",";
			ids += list[i].value;
		}
		
		return ids;
	}
});

/* [_iOculus_]
 *
 * iOculus JavaScript framework.
 *
 */

var iScheme = Class.create();
Object.extend(iScheme.prototype, Event.Publisher);
Object.extend(iScheme.prototype, {
	initialize : function()
	{
		this.name = '';
	},

	bind : function(handler)
	{
		return handler.bindAsEventListener(this);
	},
	
	getAllInstances : function(list)
	{
		if (!list) list = false;
		
		var schemes = document.getElementsByClassName('scheme_' + this.name);
		if (!schemes) return null;
		if (list == false) return schemes;

		var ids = '';

		schemes.each(function(scheme) {
			if (scheme.id) {
				if (ids != '') ids += ',';
				ids += scheme.id;
			}
		});
		
		return ids;
	}
});

var iCore = Class.create();
Object.extend(iCore.prototype, Event.Listener);
Object.extend(iCore.prototype, {
 	schemes : new Array(),
	events : null,
	
	initialize : function()
	{
		var query = document.location.toString();
		
		if (query.indexOf('?') == -1)
		{
			this.args = new Array();
			this.module = '';
			this.action = '';
		}
		else
		{
			this.args = query.substr(query.indexOf('?')).parseQuery();
			this.module = this.args.m;
			this.action = this.args.act;
		}
	},
 
	_onLoad : function(module, action)
	{
		if (module) this.module = module;
		if (action) this.action = action;

		for (var i = 0;i < this.schemes.length;i++)
		{
			if (this.schemes[i].onLoad) this.schemes[i].onLoad(this);
			if (this.schemes[i].events) {
				if (this.events == null) this.events = new Object();
				Object.extend(this.events, this.schemes[i].events);
			}
		}
		if (this.onLoad) this.onLoad();
		if (this.events) EventSelectors.start(this.events);
	},

	_onPreload : function(module, action)
	{
		if (this.schemes) {
			this.schemes.each(function(scheme) {
				if (scheme.includes) {
					scheme.includes.each(function(src) {
						Core.include(src);
					});
				}
				if (scheme.onPreload) scheme.onPreload(this);
			});
		}		
	},

	_onPostload : function(module, action)
	{
		if (this.schemes) {
			this.schemes.each(function(scheme) {
				if (scheme.onPostload) scheme.onPostload(this);
			});
		}		
	},

	_registerIdListener : function(idName, eventName, handler)
	{
		var element = $(idName);
		if (element == null) return true;
		
		Event.observe(element, eventName, handler);
		
		return false;
	},

	_registerClassListener : function(className, eventName, handler)
	{
		var elements = document.getElementsByClassName(className);		
		for (var i = 0;i < elements.length;i++) Event.observe(elements[i], eventName, handler);
		
		return false;
	},

	_registerIdListenerOnChildren : function(element, eventName, handler)
	{
		for (var i = 0;i < element.childNodes.length;i++)
		{
			Event.observe(element.childNodes[i], eventName, handler);
		}
		
		return false;
	},

	_registerClassListenerOnChildren : function(className, eventName, handler)
	{
		var elements = document.getElementsByClassName(className);

		for (var j = 0;j < elements.length;j++)
		{
			for (var i = 0;i < elements[j].childNodes.length;i++)
			{
				Event.observe(elements[j].childNodes[i], eventName, handler);
			}
		}
		
		return false;
	},

	observe : function(id, name, handler)
	{
		var pattern = /^\.(.*?) *(\*)?$/;
		var matches = pattern.exec(id);
		if (matches)
		{
			if (matches[2] != undefined)
			{
				var element = $(matches[1]);
				if (matches[1] == null) return true;
				return this._registerClassListenerOnChildren(matches[1], name, handler);
			} else return this._registerClassListener(matches[1], name, handler);
		}

		var pattern = /^#(.*?) *(\*)?$/;
		var matches = pattern.exec(id);
		if (matches)
		{
			if (matches[2] != undefined)
			{
//				alert('Length: ' + matches.length + ' Matches[2] = ' + matches[2]);
				var element = $(matches[1]);
				if (matches[1] == null) return true;
				return this._registerIdListenerOnChildren(element, name, handler);
			} else return this._registerIdListener(matches[1], name, handler);
		}
		
		return true;
	},
	
	bind : function(handler)
	{
		return handler.bindAsEventListener(this);
	},

	/* ..:: Schemes ::.. */
	
	registerScheme : function(obj)
	{
		if (obj.name == undefined || obj.name == '') return true;
		obj.name = obj.name.toLowerCase();
		if (this.schemes.indexOf(obj.name) >= 0) return true;
		this.schemes.push(obj);
		
		return false;
	},

	getScheme : function(name)
	{
		name = name.toLowerCase();
		var scheme = this.schemes.detect(function(value, index) { if (value.name == name) return true; });
		if (scheme) return scheme;
		else return false;
	},
	
	schemeObserve : function(name, eventName, handler)
	{
		var scheme = this.getScheme(name);
		if (!scheme) return true;
		
		this.listenForEvent(scheme, eventName, false, handler);

		return false;
	},
	
	iURL : function(module, action, params)
	{
		var url = $H({m : module});
		if (action) url = url.merge($H({act : action}));
		if (params) url = url.merge($H(params));
		var full_url = '/?' + url.toQueryString();
		
		return full_url;
	},
	
	ajaxRequest : function(module, action, params, failure, success)
	{
		var ajaxParams = {method : 'post'};
		if (params) ajaxParams.parameters = $H(params).toQueryString();
		if (failure) ajaxParams.onFailure = failure;
		if (success) ajaxParams.onComplete = success;
		
		var myAjax = new Ajax.Request(this.iURL(module, action, {mode : 'ajax'}), ajaxParams);
	},
	
	include : function(src)
	{
		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.src = src;
		document.getElementsByTagName('head')[0].appendChild(script);
	} 
});

var Core = new iCore();
