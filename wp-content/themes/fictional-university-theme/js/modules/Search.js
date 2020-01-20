import $ from 'jquery';

class Search{

  //1. Describe ande create/iniciate our object
  constructor(){
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");

    this.isOverlayOpen = false;

    this.events();
  }

  // Events
  events(){
    this.openButton.on( "click", this.openOverlay.bind(this) ); //---> el 'bind(this)' es para que cuando estemos dentro de la función 'openOverlay' al hacer mención a this entienda el this referido a la clase en la que estamos y no el this referido al elemento al que hemos hecho click!!
    this.closeButton.on( "click", this.closeOverlay.bind(this) );
    $(document).on("keyup", this.keyPressDispacher.bind(this));

  }

  //Methods (function, action...)
  keyPressDispacher( e ){
    if( e.keyCode == 83 && !this.isOverlayOpen ){
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