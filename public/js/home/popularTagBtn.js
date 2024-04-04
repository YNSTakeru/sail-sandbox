"use strict";

const popularTagBtn = document.querySelectorAll(".sidebar .tag-list .tag-pill");

popularTagBtn.forEach((tagBtn) => {
    tagBtn.addEventListener("click", () => {
        const tag = tagBtn.innerText;

        // データの更新
        fetch(
            `/api/articles?tag=${tag}`,
            { method: "GET" },
            { credentials: "same-origin" },
            { headers: { "Content-Type": "application/json" } },
        )
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                console.log("サーバーのデータを受け取り");
            });
    });
});
