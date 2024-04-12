document.addEventListener("DOMContentLoaded", function () {
    const $tagInput = document.getElementById("tag-input");

    const $tag = document.querySelectorAll(
        ".tag-list .tag-pill .ion-close-round",
    );

    for (let i = 0; i < $tag.length; i++) {
        $tag[i].addEventListener("click", (e) => {
            e.target.parentElement.remove();
        });
    }

    $tagInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();

            if (e.target.value === "") {
                return;
            }

            const tagName = e.target.value;

            const $tagList = document.querySelector(".tag-list");

            const $icon = document.createElement("i");
            $icon.classList.add("ion-close-round");

            $icon.addEventListener("click", (e) => {
                e.target.parentElement.remove();
            });

            const $tagPill = document.createElement("span");
            $tagPill.classList.add("tag-default", "tag-pill");

            $tagPill.dataset.tag_name = tagName;

            $tagPill.appendChild($icon);
            $tagPill.appendChild(document.createTextNode(tagName));

            $tagList.appendChild($tagPill);

            e.target.value = "";
        }
    });
});

document.querySelector("form").addEventListener("submit", (e) => {
    const tags = Array.from(
        document.querySelectorAll(".tag-list .tag-pill"),
    ).map((span) => span.dataset.tag_name);

    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "tags";
    input.value = JSON.stringify(tags);
    e.target.appendChild(input);
});
