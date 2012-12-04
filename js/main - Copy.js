var Person = Backbone.Model.extend({
	defaults: {
		firstName : "nitesh",
		occupation : "dev",
		gendar : "male",
		age : 23
	}, 

	validate: function(attrs){
		if(attrs.age<0){
			return "please provide right age"
		}
	}

});


var PersonView = Backbone.View.extend({
	tagName :"li",

	template : _.template($("#temp").html()),

	initialize: function(){
		this.render();
	},

	render : function(){

		var data = this.model.toJSON();
		this.$el.html(this.template(data));
		return this;
	}
})


var PeopleCollectionView = Backbone.View.extend({

	tagName : "ul",

	initialize: function(){
		this.render();
	},

	render : function(){
		this.collection.each(function(person){
			var personView = new PersonView({
				model: person
			});

			this.$el.append(personView.el);
		
		}, this);

		
	}

})

var PeopleCollection = Backbone.Collection.extend({
	model : Person
})



var peopleCollection = new PeopleCollection([
		{
			firstName : "nitesh",
			age : "29"
		},
		{
			firstName : "sanjeev",
			age: 27
		}
]);


var peopleCollectionView = new PeopleCollectionView({
	collection: peopleCollection
})

// var personView = new PersonView({
// 	model : person
// })






