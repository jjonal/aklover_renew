/* BLOG URL ���ø� */
var BLOG_ADD = {
	idx : 1,

	init : function() {
		$("#blogUrlTd").on("click", ".btn_blogUrl_del", this.deleteData.bind(this));
	},
	renderData : function(data) {
		var template = $("#blogUrlAddTemplate").html();
		Mustache.parse(template);
		return Mustache.render(template, data);
	},
	deleteData : function(event) {
		var row = $(event.target).closest("li");
		row.remove();
		this.idx--;

	},
	deleteRow : function() {
		var row = $("#blogUrlTd tr:last");
		row.remove();
		this.idx--;

	},
	appendData : function(data){
		data.idx = this.idx;
		$("#blogUrlTd").append(  this.renderData(data) );
		this.idx++;
	}
};
var blogUrlAdd = function(index){
	BLOG_ADD.appendData({});
};

/* CAFE URL ���ø�*/
var CAFE_ADD = {
	idx : 1,

	init : function() {
		$("#cafeUrlTd").on("click", ".btn_cafeUrl_del", this.deleteData.bind(this));
	},
	renderData : function(data) {
		var template = $("#cafeUrlAddTemplate").html();
		Mustache.parse(template);
		return Mustache.render(template, data);
	},
	deleteData : function(event) {
		var row = $(event.target).closest("li");
		row.remove();
		this.idx--;

	},
	deleteRow : function() {
		var row = $("#cafeUrlTd tr:last");
		row.remove();
		this.idx--;

	},
	appendData : function(data){
		data.idx = this.idx;
		$("#cafeUrlTd").append(  this.renderData(data) );
		this.idx++;
	}
};
var cafeUrlAdd = function(index){
	CAFE_ADD.appendData({});
};

/* SNS URL ���ø�*/
var SNS_ADD = {
	idx : 1,

	init : function() {
		$("#snsUrlTd").on("click", ".btn_snsUrl_del", this.deleteData.bind(this));
	},
	renderData : function(data) {
		var template = $("#snsUrlAddTemplate").html();
		Mustache.parse(template);
		return Mustache.render(template, data);
	},
	deleteData : function(event) {
		var row = $(event.target).closest("li");
		row.remove();
		this.idx--;

	},
	deleteRow : function() {
		var row = $("#snsUrlTd tr:last");
		row.remove();
		this.idx--;

	},
	appendData : function(data){
		data.idx = this.idx;
		$("#snsUrlTd").append(  this.renderData(data) );
		this.idx++;
	}
};
var snsUrlAdd = function(index){
	SNS_ADD.appendData({});
};

/* ��Ÿ URL ���ø�*/
var ETC_ADD = {
	idx : 1,

	init : function() {
		$("#etcUrlTd").on("click", ".btn_etcUrl_del", this.deleteData.bind(this));
	},
	renderData : function(data) {
		var template = $("#etcUrlAddTemplate").html();
		Mustache.parse(template);
		return Mustache.render(template, data);
	},
	deleteData : function(event) {
		var row = $(event.target).closest("li");
		row.remove();
		this.idx--;

	},
	deleteRow : function() {
		var row = $("#etcUrlTd tr:last");
		row.remove();
		this.idx--;

	},
	appendData : function(data){
		data.idx = this.idx;
		$("#etcUrlTd").append(  this.renderData(data) );
		this.idx++;
	}
};
var etcUrlAdd = function(index){
	ETC_ADD.appendData({});
};