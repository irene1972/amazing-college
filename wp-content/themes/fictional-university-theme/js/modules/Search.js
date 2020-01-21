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


    // Para ejecuciones asíncronas: solo cuando se ejecuten todas las peticiones incluidas dentro del 'when' => se ejecutará el código indicado en el 'then'
    /*
    $.when(
      $.getJSON( universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val() ), 
      $.getJSON( universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val() )
      ).then((posts, pages) => {

      var combinedResults = posts[0].concat(pages[0]);

      this.resultsDiv.html(`
      <h2 class="search-overlay__section-title">General Information</h2>
      ${( combinedResults.length ) ? '<ul class="link-list min-list">' : '<p>No general information matches that search.</p>'}
        ${combinedResults.map(item=>`<li><a href="${item.link}">${item.title.rendered}</a> ${ ( item.type=='post' ) ? `by ${item.authorName}` : ''}</li>`).join('')}
      ${( combinedResults.length ) ? '</ul>' : ''}
      `);

      this.isSpinnerVisible = false;

    }, () => {
      this.resultsDiv.html('<p>Unexpected error, please try again.</p>');
    });
          */

    // Hemos camibado la consulta genérica a la api rest de wp (comentado más abajo) por una consulta customizada a la misma api rest
    // http://localhost:3000/amazing-college/app/wp-json/university/v1/search?term=biology
    $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(), ( resp )=>{
      this.resultsDiv.html(`
      <div class="row">
        <div class="one-third">
          <h2 class="search-overlay__section-title">General Information</h2>
          ${( resp.general_info.length ) ? '<ul class="link-list min-list">' : '<p>No general information matches that search.</p>'}
            ${resp.general_info.map(item=>`<li><a href="${item.permalink}">${item.title}</a> ${ ( item.post_type=='post' ) ? `by ${item.author_name}` : ''}</li>`).join('')}
          ${( resp.general_info.length ) ? '</ul>' : ''}
        </div>
        <div class="one-third">
          <h2 class="search-overlay__section-title">Programs</h2>
          ${( resp.programs.length ) ? '<ul class="link-list min-list">' : `<p>No programs match that search. <a href="${universityData.root_url}/programs">View all programs</a></p>`}
            ${resp.programs.map(item=>`<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
          ${( resp.programs.length ) ? '</ul>' : ''}
          <h2 class="search-overlay__section-title">Professors</h2>
          ${( resp.professors.length ) ? '<ul class="professor-cards">' : `<p>No professor match that search.</p>`}
            ${resp.professors.map(item=>`
              <li class="professor-card__list-item">
                <a class="professor-card" href="${item.permalink}">
                  <img class="professor-card__image"  src="${item.url_image}" alt="">
                  <span class="professor-card__name">${item.title}</span>
                </a>
              </li>
            `).join('')}
          ${( resp.professors.length ) ? '</ul>' : ''}
        </div>
        <div class="one-third">
          <h2 class="search-overlay__section-title">Campuses</h2>
          ${( resp.campuses.length ) ? '<ul class="link-list min-list">' : `<p>No campuses match that search. <a href="${universityData.root_url}/campuses">View all campuses</a></p>`}
            ${resp.campuses.map(item=>`<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
          ${( resp.campuses.length ) ? '</ul>' : ''}
          <h2 class="search-overlay__section-title">Events</h2>
          ${( resp.events.length ) ? '' : `<p>No events match that search. <a href="${universityData.root_url}/events">View all events</a></p>`}
            ${resp.events.map(item=>`
              <div class="event-summary">
                <a class="event-summary__date t-center" href="${item.permalink}">
                  <span class="event-summary__month">${item.month_event}</span>
                  <span class="event-summary__day">${item.day_event}</span>
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                  <p>${item.description}<a href="${item.permalink}" class="nu gray">Learn more</a></p>
                </div>
              </div>
            `).join('')}
        </div>
      </div>
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