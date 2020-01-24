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
        this.deleteLike( elemSpanBox );
        //elemSpanBox.data("exists", "no");
      }
      else{
        this.createLike( elemSpanBox )
        //elemSpanBox.data("exists", "yes");
      }
      
    }

    createLike( elemSpanBox ){

      var professorId = elemSpanBox.data("professor");

      $.ajax({
        url: universityData.root_url + '/wp-json/university/v1/manageLike',
        type: 'POST',
        data: { 'professorId' : professorId },
        success: ( response ) => {
          console.log('The like has been created');
          console.log( response );
        },
        error: ( response ) => {
          console.log('Sorry, there was an error');
          console.log( response );

        }
      });

    }

    deleteLike(){

      $.ajax({
        url: universityData.root_url + '/wp-json/university/v1/manageLike',
        type: 'DELETE',
        success: ( response ) => {
          console.log('The like has been deleted');
          console.log( response );
        },
        error: ( response ) => {
          console.log('Sorry, there was an error');
          console.log( response );
  
        }
      });
      
    }

}

export default Like;