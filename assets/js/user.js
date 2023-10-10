(function(){

  /**
    * Init
    */
  removeFields();

  /**
    * Handlers
    */
  function removeFields() {
    const form = findUserForm();

    if (! form) {
      return;
    }

    const elementsToRemove = [
      findUserUrlFieldRow(form),
      findUserDescriptionFieldRow(form)
    ];

    for (var i = 0; i < elementsToRemove.length; i++) {
      if (elementsToRemove[i]) {
        elementsToRemove[i].remove();
      }
    }
  }

  /**
    * Fields
    */
  function findUserForm() {
    const forms = ['your-profile', 'createuser'];

    for (var i = 0; i < forms.length; i++) {
      let form = document.getElementById(forms[i]);

      if (form) {
        return form;
      }
    }
  }

  function findUserUrlFieldRow(form) {
    const input = form.querySelector('input[name="url"]');

    return input ? input.closest('tr') : null;
  }

  function findUserDescriptionFieldRow(form) {
    return form.querySelector('tr.user-description-wrap');
  }

})();
