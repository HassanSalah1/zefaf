$(function () {

    const config = {
        apiKey: "AIzaSyAmYBWThe29LXNcN13fbwwX2avH5xpArNw",
        authDomain: "amgen360care.firebaseapp.com",
        projectId: "amgen360care",
        storageBucket: "amgen360care.appspot.com",
        messagingSenderId: "382097514747",
        appId: "1:382097514747:web:7c0c38f7d0a1a99fd8505e",
        measurementId: "G-VMX5R765KH"
    };
    firebase.initializeApp(config);
    var firebaseToken = null;
    const messaging = firebase.messaging();
// Add the public key generated from the console here.
//     messaging.usePublicVapidKey("BPOku29Fw1cVLozrjENfB0xgNb7DmpZcJA0SGfaEYJfR3_vEuXmkpG2ZIGVe1Ah9UKoiwmJBSj1eMd3BMwaGg4Y");
    messaging.requestPermission()
        .then(function () {
            messaging.getToken()
                .then(function (currentToken) {
                    console.log(currentToken);
                    if (currentToken) {
                        $.ajax({
                            url: '/update/token',
                            method: 'get',
                            data: 'device_token=' + currentToken,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                            }
                        });
                    }
                })
                .catch(function (err) {
                    console.log(err);
                });
        });


    window.addEventListener('load', function () {

// Check that service workers are supported, if so, progressively
// enhance and add push messaging support, otherwise continue without it.
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then((registration) => {
                    console.log('rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr');
                }).catch(err => {
                console.log(err)
            })
        } else {
            console.warn('Service workers aren\'t supported in this browser.');
        }
    });
//     // var config = {
//     //     apiKey: "AIzaSyBLvT_8cVQRDXK3uEDi6nSvtQ4c2k2_0bY",
//     //     authDomain: "restaurant-1518607276935.firebaseapp.com",
//     //     databaseURL: "https://restaurant-1518607276935.firebaseio.com",
//     //     projectId: "restaurant-1518607276935",
//     //     storageBucket: "restaurant-1518607276935.appspot.com",
//     //     messagingSenderId: "110488067629"
//     // };
//     // firebase.initializeApp(config);
    // const messaging = firebase.messaging();
    if ("Notification" in window) {
        console.log('notigfication');
    }
    messaging.onMessage(function (payload) {
        if (Notification.permission === "granted") {
            console.log('granted');
        } else {
            console.log('not granted');
        }
        console.log("Message received. ", payload);
        const title = payload.data.title;
        const body = payload.data.message;
        // const options = {
        //     body: payload.data.body,
        //     tag: payload.from,
        //     data: payload.data,
        // };
        let link = '';
        if (payload.data.type === 'user') {
            link = baseNotificationLink + '/users'
        }else if (payload.data.type === 'lapTests') {
            link = baseNotificationLink + '/journey/lapTests'
        }else if (payload.data.type === 'product') {
            link = baseNotificationLink + '/journey/product'
        }else if (payload.data.type === 'nurse') {
            link = baseNotificationLink + '/journey/nurse'
        }

        displayNotification(title, body, link);
    });

});

function displayNotification(title, body, link) {

    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification(title, {
            icon: 'https://amgen360care.intermarkfileup.com/dashboard/images/users/logo@2x.png',
            body: body,
            data: {
                link: link
            }
        });
        notification.onclick = (e) => {
          window.location.href = e.target.data.link;
        };
    }

    // const greeting = new Notification('Hi, How are you?');

    // toastr.options.showDuration = 1000;
    // toastr.options.onclick = function () {
    //     console.log(link);
    //     window.location = link;
    // };
    // toastr['success'](body, title);
    // Notification.requestPermission(function(result) {
    //     console.log(result);
    //     if (result === 'granted') {
    //         navigator.serviceWorker.getRegistrations().then(function (registrations) {
    //             registrations[0].showNotification('Notification' , { body:"Here is the body!" });
    //             // event.waitUntil(self.registration.showNotification("Hello world!", options));
    //
    //         });
    //     }
    // });

    // const notification = new Notification(title, {
    //     body: body,
    //     icon: 'https://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
    //     data: {
    //         link :link
    //     }
    // });
    // notification.onclick =  (e) => {
    //    console.log(e);
    // };
}
