Drupal.behaviors.myBehavior = {
  attach: function (context, settings) {

    once('button-block-click', 'button.radicati-button', context).forEach(
        function (element) {
          if(element.dataset.handleClick === '0') {
            return;
          }

          // Add a click handler that calls radButtonPressed and passes in context.
          element.addEventListener('click', function () {
            radButtonPressed(element);
          });

          // Set the aria-expanded state to false.
          element.setAttribute('aria-expanded', 'false');

          // Get the element controlled by the button.
          var ariaControls = element.getAttribute('aria-controls');

          // Set the aria-hidden state to true.
          var controlledElement = document.getElementById(ariaControls);
          controlledElement.setAttribute('aria-hidden', 'true');
        }
    );

    function radButtonPressed(element) {
      // get the aria-controls attribute
      var ariaControls = element.getAttribute('aria-controls');

      // toggle the active state on the element controlled by aria controls.
      var controlledElement = document.getElementById(ariaControls);
      controlledElement.classList.toggle('active');

      // Set aria-hidden to the opposite of the current state.
      var ariaHidden = controlledElement.getAttribute('aria-hidden');
      controlledElement.setAttribute('aria-hidden', ariaHidden === 'true' ? 'false' : 'true');

      // Toggle the aria-expanded state on the button.
      var ariaExpanded = element.getAttribute('aria-expanded');
      element.setAttribute('aria-expanded', ariaExpanded === 'true' ? 'false' : 'true');

      // If data-alt-icon-class is set on the element, save the current icon class from
      // the i element inside the element and then swap the icon class with the value
      // of data-alt-icon-class.
      if (element.getAttribute('data-alt-icon-classes')) {
        var iconElement = element.querySelector('i');
        var currentIconClass = iconElement.getAttribute('class');
        iconElement.setAttribute('class', element.getAttribute('data-alt-icon-classes'));
        element.setAttribute('data-alt-icon-classes', currentIconClass);
      }
    }
  }
};