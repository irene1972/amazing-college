import $ from 'jquery';

class Search{

  //1. Describe ande create/iniciate our object
  constructor(){
    this.addSearchHTML();
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
        
        this.typingTimer = setTimeout( this.getResults.bind(this), 750 );

      }else{

        this.resultsDiv.html('');
        this.isSpinnerVisible = false;

      }
        
    }

    this.previousValue = this.searchField.val();
      
  }

  getResults(){
 
    // $.getJSON( 'http://localhost:3000/amazing-college/app/wp-json/wp/v2/posts?search=' + this.searchField.val(), function( posts ){
    //   alert(posts[0].title.rendered);
    // }.bind(this));
  
    $.getJSON( universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val(), posts => {
      this.resultsDiv.html(`
      <h2 class="search-overlay__section-title">General Information</h2>
      ${( posts.length ) ? '<ul class="link-list min-list">' : '<p>No general information matches that search.</p>'}
        ${posts.map(item=>`<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
      ${( posts.length ) ? '</ul>' : ''}
      `);

      this.isSpinnerVisible = false;

    });
  }

  keyPressDispacher( e ){
    if( e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(":focus") ){
      this.openOverlay();
    }

    if( e.keyCode == 27  && this.isOverlayOpen ){
      this.closeOverlay();
    }

  }

  openOverlay(){
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.searchField.val('');
    setTimeout( () => this.searchField.focus(), 301);
    this.isOverlayOpen = true;
  }

  closeOverlay(){
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }

  addSearchHTML(){
    $("body").append(`
      <div class="search-overlay">
        <div class="search-overlay__top">
          <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What ar you looking for?" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
          </div>
        </div>

        <div class="container">
          <div id="search-overlay__results"></div>
        </div>

      </div>
    `);
  }

}

export default Search;