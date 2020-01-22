import $ from 'jquery';

class MyNotes{

  constructor(){

    this.editButton = $(".edit-note");
    this.deleteButton = $(".delete-note");
    this.events();
  }

  events(){
    this.editButton.on( "click", this.editNote.bind(this) );
    this.deleteButton.on( "click", this.deleteNote.bind(this) );
  }

  editNote(){
    alert('Editamos!!');
  }

  deleteNote(){
    alert('Eliminamos!!');
  }
  
}

export default MyNotes;