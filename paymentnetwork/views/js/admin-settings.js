// Module admin settings JavaScript
const ModuleName = 'payment_network';

window.onload = function () {
  // Fix to remove the novalidate attribute from the module
  // configuration form that prevents required fields being enforced.
  var ConfigurationForm = document.getElementById("configuration_form");
  ConfigurationForm.removeAttribute("novalidate");

  // Validation fields.
  var GatewayURLField = document.getElementById(ModuleName + "_gateway_url");
  // On configuration form submit validate the form data.
  ConfigurationForm.onsubmit = validate;

  function validate(event) {
    // Validate the Gateway URL being passed in.
    if (!GatewayURLField.value
      .match(/(https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
      )) {
      event.preventDefault()
      GatewayURLField.style.border = "1px solid #ff0000";

    }
    // If nothing is invalid then return.
    return;
  }
};
