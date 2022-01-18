const nav = document.getElementById("nav-menu");
const nav_hamburger = document.getElementById("nav-hamburger");

const MessageType = {
    info: "info",
    warning: "warning",
    success: "success",
    error: "error",
};


if (nav == null) {
    nav_hamburger.remove();
}

let activeMenus = [];

if (nav != null && nav_hamburger != null) {
    nav_hamburger.addEventListener("click", function () {
        toggleMenu();
    })

    function toggleMenu() {
        activeMenus.push(nav);
        nav.classList.toggle("menu-active");
        nav_hamburger.classList.toggle("menu-active");
    }
}

function showSqlResult(item) {
    item.classList.toggle("selected");
}

function checkAnswer(item, correct) {
    if (correct) {
        item.classList.add("answer-correct");
        let parentItem = item.closest('#quiz-box');
        parentItem.classList.add("answered");
    } else {
        item.classList.add("answer-wrong");
    }
}

document.onclick = function (e) {
    for (let i = 0; i < activeMenus.length; i++) {
        if (activeMenus[i] !== e.target) {
            if (nav === activeMenus[i]) {
                if (e.target !== nav && e.target !== nav_hamburger) {
                    activeMenus[i].classList.remove("menu-active");
                    activeMenus.splice(i, 1);
                    nav_hamburger.classList.remove("menu-active");
                }
            } else {
                activeMenus[i].classList.remove("menu-active");
                activeMenus.splice(i, 1);
            }
        }
    }
}

function activateNavMenu(item) {
    activeMenus.push(item);
    item.classList.add("menu-active");
}

const hashCode = s => s.split('').reduce((a, b) => (((a << 5) - a) + b.charCodeAt(0)) | 0, 0)
let messages = []

function close_message(obj) {
    setTimeout(() => obj.classList.add("hidden"), 10000);
    setTimeout(() => {
        obj.remove();
        messages.pop();
    }, 10250);
}

function show_message(message_text, type = MessageType.info) {
    let hash = hashCode(message_text);
    if (!messages.includes(hash)) {
        let holder = document.getElementById("message_holder");
        let message = document.createElement("div");
        message.classList.add("message");
        message.classList.add(type);
        message.innerHTML = message_text;
        holder.prepend(message);
        close_message(message);
        messages.push(hash);
    }
}

function validateRegister() {
    // let regexName = /[AaĄąBbCcĆćDdEeĘęFfGgHhIiJjKkLlŁłMmNnŃńOoÓóPpRrSsŚśTtUuWwYyZzŹźŻż\d\_\-]{2,29}/;
    let regexName = /^(?!.*\.\.)(?!.*\.$)[^\Wąćęłńóśżź][\wąćęłńóśżź.]{2,29}$/igm

    if (!regexName.test(document.register_form.name.value)) {
        show_message("Pseudonim musi być dłuższy niż 2 znaki i składać tylko się z liter, cyfr lub znaków: . _", MessageType.error);
        document.register_form.name.focus();
        return false;
    }

    let regexPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/gm
    if (!regexPassword.test(document.register_form.password.value)) {
        show_message("Hasło:<ul><li>musi być dłuższe niż 8 znaków</li> <li>może składać się tylko z liter, cyfr lub znaków</li></ul>Musi zawierać:<ul><li>jedną małą literę</li><li>jedną dużą literę</li><li>jedną cyfrę.</li></ul>", MessageType.error);
        document.register_form.password.focus();
        return false;
    }

    if (document.register_form.password.value !== document.register_form.confirmedPassword.value) {
        show_message("Hasła nie pasują do siebie.", MessageType.error);
        document.register_form.password.focus();
        return false;
    }

    return 0;
}


async function ParseAdminForm(e) {
    let form = new FormData(e);

    let method = e.getAttribute("method")
    let action = e.getAttribute("action")

    console.log(method)
    console.log(action)

    const data = {}

    form.forEach((value, key) => {
        data[key] = value.toString();
    });

    const requestOptions = {
        method: method,
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    }

    try {
        const response = await fetch(action, requestOptions);


        const jsonResponse = await response.json();

        if (response.status !== 200) {
            alert(jsonResponse);
        } else {

            if (method === "POST")
                location.assign(jsonResponse['item_link'])
            else
                location.reload();
        }


        return await response.json();
    } catch (e) {
        return {error: e}
    }
}

async function DeleteAdminAction(api, object_id) {

    let method = 'DELETE';
    let action = api;

    const data = {id: object_id}

    const requestOptions = {
        method: method,
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    }

    try {
        const response = await fetch(action, requestOptions);

        if (response.status !== 200) {
            alert(response.json())
        } else {
            location.reload();
        }

        return await response.json();
    } catch (e) {
        return {error: e}
    }
}


window.addEventListener("load", function () {
    let form_admin = document.getElementById('form-admin');

    if (form_admin !== null) {
        form_admin.addEventListener("submit", async function (e) {
            e.preventDefault(); // before the code
            /* do what you want with the form */

            ParseAdminForm(form_admin).then(t => {
                console.log(t);
            });
        })
    }
});


function processAdminForm(e) {
    e.preventDefault();
    let form = new FormData(e);
    console.log(e);
}

