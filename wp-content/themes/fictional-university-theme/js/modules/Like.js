import $ from 'jquery';

class Like{

    constructor(){
      this.spanBox = $(".like-box");
      this.events();
    }

    events(){
      this.spanBox.on("click", this.changeStatus.bind(this) );
    }

    // methods
    changeStatus( e ){
      //var elemSpanBox = $(e.target).closest(".like-box");
      var elemSpanBox = $(e.target).parents("span");

      if( elemSpanBox.data("exists") == "yes" ){
        this.deleteLike();
        //elemSpanBox.data("exists", "no");
      }
      else{
        this.createLike()
        //elemSpanBox.data("exists", "yes");
      }
      
    }

    createLike(){
      alert('created');
    }

    deleteLike(){
      alert('deleted');
    }

}

export default Like;