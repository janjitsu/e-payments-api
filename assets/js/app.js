/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

(function(){
    //getSessionId
    var senderHash, creditCardParams, creditCardToken;
    console.log('getting pagseguro session');

    creditCardParams = {
        cardNumber: "5031433215406351", //cartão de crédito de teste
        brand: "mastercard",
        cvv: "123",
        expirationMonth: "01",
        expirationYear: "2021",
        success: function(data){
            console.log('success get credit card token')
            creditCardToken = data['card']['token'];
            $('#creditCardToken').html(creditCardToken);
            console.log(data);
        },
        error: function(data){
            console.log('error get credit card token')
            console.log(data);
        },
        complete: function(data){
            console.log('completed get credit card token')
            console.log(data);
        },
    }

    $.getJSON('/pagseguro/session')
      .then(function(data){
        console.log('success getting pagseguro session');
        console.log(data);
        // Set pagseguro session Id (Required)
        PagSeguroDirectPayment.setSessionId(data.sessionId);
        PagSeguroDirectPayment.createCardToken(creditCardParams);

        // Get sender hash generated from client
        senderHash = PagSeguroDirectPayment.getSenderHash();
        console.log(senderHash);
        $('#senderHash').html(senderHash);
      })
      .fail(function(data){
          console.log('error getting pagseguro session');
          console.log(data);
      });


    $('#pay').click(function(){
        $.post('/pagseguro/creditCardPayment',{
            creditCardToken: creditCardToken,
            senderHash: senderHash,
            donationAmount: "1.00",
            street: 'Av. Brig. Faria Lima',
            number: "1384",
            neighborhood: "Jardim Paulistano",
            zipCode: '01452002',
            city: "São Paulo",
            state: "SP",
            complement: "apto. 114",
            buyerBirthDate: "01/10/1979",
            buyerName: "Joao Comprador",
            buyerCardName: "Joao Comprador",
            buyerCPF: "66803908852",
            buyerPhone: "1156273440",
            buyerEmail: "joaocomprador@sandbox.pagseguro.com.br"
        })
        .then(function(data){
            console.log('success');
            console.log(data);
        })
        .fail(function(data){
            console.log('fail');
            console.log(data);
        })
    });
})();
