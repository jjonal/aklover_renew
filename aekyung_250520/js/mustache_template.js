/* start youtube url ���ø� */
var YOUTUBE_ADD = {
	idx : 1,

	init : function() {
		$("#youtubeUrlTd").on("click", ".btn_youtubeUrl_del", this.deleteData.bind(this));
	},
	renderData : function(data) {
		var template = $("#youtubeUrlAddTemplate").html();
		Mustache.parse(template);
		return Mustache.render(template, data);
	},
	deleteData : function(event) {
		var row = $(event.target).closest("li");
		row.remove();
		this.idx--;

	},
	deleteRow : function() {
		var row = $("#youtubeUrlTd tr:last");
		row.remove();
		this.idx--;

	},
	appendData : function(data){
		data.idx = this.idx;
		$("#youtubeUrlTd").append(  this.renderData(data) );
		this.idx++;
	}
};
var youtubeUrlAdd = function(index){
	if(!index) index = 1;
	var cnt = 5 - index;
	if( YOUTUBE_ADD.idx > cnt ){
		alert('5������ �߰� �����մϴ�.');
		return;
	}
	YOUTUBE_ADD.appendData({});
};
/* end youtube url ���ø� */

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
	if(!index) index = 1;
	var cnt = 5 - index;
	if( BLOG_ADD.idx > cnt ){
		alert('5������ �߰� �����մϴ�.');
		return;
	}
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
	if(!index) index = 1;
	var cnt = 5 - index;
	if( CAFE_ADD.idx > cnt ){
		alert('5������ �߰� �����մϴ�.');
		return;
	}
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
	if(!index) index = 1;
	var cnt = 5 - index;
	if( SNS_ADD.idx > cnt ){
		alert('5������ �߰� �����մϴ�.');
		return;
	}
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
	if(!index) index = 1;
	var cnt = 5 - index;
	if( ETC_ADD.idx > cnt ){
		alert('5������ �߰� �����մϴ�.');
		return;
	}
	ETC_ADD.appendData({});
};