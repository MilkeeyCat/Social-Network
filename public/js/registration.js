const form = document.querySelector("form");

form.onsubmit = async function(e) {
    console.log(this);
    e.preventDefault();

    const data = {
        "firstName": this.querySelector("input[name='firstName']").value,
        "lastName": this.querySelector("input[name='lastName']").value,
        "emailOrPassword": this.querySelector("input[name='emailOrPassword']").value,
        "password": this.querySelector("input[type='password']").value,
        "bornDate": {
            "date": this.querySelector("select#select-date").value,
            "month": this.querySelector("select#select-month").value,
            "year": this.querySelector("select#select-year").value
        },
        "gender": this.querySelector("input[name='gender']").value,
    };

    const f = await fetch("/register", {
        headers: {
          "Content-Type": "application/json"
        },
        method: "POST",
        body: JSON.stringify(data)
    });

    this.reset();
}