window.App = {
	Models : {},
	Collections: {},
	Views: {}
};


App.Models.Task = Backbone.Model.extend({

	validate: function(attrs){
		if(attrs.title == ""){
			return "falied";
		}
	}

});


App.Views.Task = Backbone.View.extend({
	

	initialize: function(){

		this.model.on("change", this.render, this);
		this.model.on("destroy", function(){
			this.$el.remove();
		}, this);
		// this.model.on("destroy", function(){
		// 	this.$el.remove();
		// }, this);

	},

	tagName:"li",

	template : _.template($("#taskTemplate").html()), 

	events: {
		"click .edit": "editTask",
		"click .delete" : "remove"
	},

	editTask: function(){
		var newTask = prompt("enter new Task", this.model.get("title"));
		this.model.set("title", newTask);
		
	},

	remove: function(){
		this.model.destroy();
	},

	render: function(){
	
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	}
});


App.Collections.Task = Backbone.Collection.extend({
	model: App.Models.Task
});

App.Views.TaskCollection = Backbone.View.extend({
	tagName: "ul",



	initialize: function(){
		this.render();
		this.collection.on("add", this.addOne, this)

	},

	render:function(){
		this.collection.each(this.addOne, this);


	}, 

	addOne : function(task){
			var taskView = new App.Views.Task({model : task});
			this.$el.append (taskView.render().el);
	}
})

App.Views.NewTask = Backbone.View.extend({
	el : ".addTask",

	events:{
		"click .submit": "getNewTask"
	},

	getNewTask: function(e){
		e.preventDefault();
		var newTaskForm = this.$el;
		var newTask = newTaskForm.find(".inputText").val();

		tasks.add({
			title: newTask
		});
	},

	initialize: function(){

	}
});

var tasks = new App.Collections.Task([{
	"title":"learn git",
	"complete": true
}, {
	"title": "learn backbone",
	"complete": false
}, 
{
	"title": "learn node",
	"complete": false
}]);


var tasksView = new App.Views.TaskCollection({
	collection: tasks
});

new App.Views.NewTask()

$(".tasklist").html(tasksView.el)
// var task = new App.Models.Task();
// var taskview = new App.Views.Task({
// 	model:task
// });