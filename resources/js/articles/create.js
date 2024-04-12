document.addEventListener("DOMContentLoaded", function () {
    const $tagInput = document.getElementById("tag-input");

    $tagInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();

            if (e.target.value === "") {
                return;
            }

            const tagName = e.target.value;

            // タグの追加
            const $tagList = document.querySelector(".tag-list");

            const $icon = document.createElement("i");
            $icon.classList.add("ion-close-round");

            $icon.addEventListener("click", (e) => {
                e.target.parentElement.remove();
            });

            const $tagPill = document.createElement("span");
            $tagPill.classList.add("tag-default", "tag-pill");

            $tagPill.appendChild($icon);
            $tagPill.appendChild(document.createTextNode(tagName));

            $tagList.appendChild($tagPill);

            e.target.value = "";
        }
    });
});
