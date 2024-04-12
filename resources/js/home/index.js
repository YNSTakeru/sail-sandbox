"use strict";

const $feedToggle = document.querySelector(".feed-toggle .nav");

function setActive() {
    const $navLink = $feedToggle.querySelectorAll(".nav-link");

    const url = window.location.href;

    const isTag = url.includes("?tag=");

    const decodeUrl = decodeURI(url);
    console.log(decodeUrl);

    if (!isTag) return;

    for (let i = 0; i < $navLink.length; i++) {
        if ($navLink[i].classList.contains("active")) {
            $navLink[i].classList.remove("active");
        }
    }

    const $navItem = document.createElement("li");
    const $newNavLink = document.createElement("a");

    $navItem.classList.add("nav-item");
    $newNavLink.classList.add("nav-link", "active");
    $newNavLink.href = `${decodeUrl}`;
    $newNavLink.textContent = decodeUrl.split("tag=")[1];
    $navItem.appendChild($newNavLink);
    $feedToggle.appendChild($navItem);

    if ($navLink[1]) {
        $navLink[1].classList.add("active");
    }
}

setActive();
