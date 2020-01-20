import $ from 'jquery';

class Search{

  //1. Describe ande create/iniciate our object
  constructor(){
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.resultsDiv = $("#search-overlay__results");

    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;

    this.typingTimer;
    this.previousValue;

    this.events();
  }

  // Events
  events(){
    this.openButton.on( "click", this.openOverlay.bind(this) ); //---> el 'bind(this)' es para que cuando estemos dentro de la función 'openOverlay' al hacer mención a this entienda el this referido a la clase en la que estamos y no el this referido al elemento al que hemos hecho click!!
    this.closeButton.on( "click", this.closeOverlay.bind(this) );
    $(document).on("keydown", this.keyPressDispacher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  //Methods (function, action...)
  typingLogic(){

    if( this.searchField.val() != this.previousValue ){

      clearTimeout(this.typingTimer);
      
      if( this.searchField.val() ){

        if( !this.isSpinnerVisible ){
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        
        this.typingTimer = setTimeout( this.getResults.bind(this), 2000 );

      }else{

        this.resultsDiv.html('');
        this.isSpinnerVisible = false;

      }
        
    }

    this.previousValue = this.searchField.val();
      
  }

  getResults(){
    this.resultsDiv.html('Imagine real search results here...');
    this.isSpinnerVisible = false;
  }

  keyPressDispacher( e ){
    if( e.keyCode == 83 && !this.isOverlayOpen && $("input, textarea").is(":focus") ){
      this.openOverlay();
    }

    if( e.keyCode == 27  && this.isOverlayOpen ){
      this.closeOverlay();
    }

  }

  openOverlay(){
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.isOverlayOpen = true;
  }

  closeOverlay(){
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }

}

export default Search;