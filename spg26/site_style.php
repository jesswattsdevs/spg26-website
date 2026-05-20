<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Georgia, "Times New Roman", serif;
    background: linear-gradient(180deg, #f6f8fb 0%, #dce7ef 100%);
    color: #1c2d39;
    line-height: 1.5;
}

.page-shell {
    max-width: 1100px;
    margin: 28px auto;
    padding: 24px;
}

.card {
    background: #ffffff;
    border: 1px solid #d5e0e8;
    border-radius: 18px;
    box-shadow: 0 18px 40px rgba(32, 56, 71, 0.12);
    padding: 28px 30px;
}

h1, h2, h3 {
    color: #17384d;
    margin-top: 0;
}

a {
    color: #325d7a;
    font-weight: bold;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.error {
    color: #b42318;
}

.success {
    color: #0f7a35;
}

.info-box {
    padding: 12px 14px;
    border-radius: 10px;
    margin: 14px 0;
    background: #eef5f9;
    border: 1px solid #d5e0e8;
}

.info-box.error {
    background: #fff1ef;
    border-color: #f2c0ba;
}

.info-box.success {
    background: #effaf2;
    border-color: #b8dfc3;
}

.nav-wrap {
    margin: 18px 0 24px;
    padding: 14px 16px;
    background: #edf3f7;
    border-radius: 12px;
}

.nav-wrap h3 {
    margin: 0;
}

.nav-wrap a {
    display: inline-block;
    margin: 4px 6px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    margin-top: 18px;
}

.data-table th,
.data-table td {
    border: 1px solid #ced9e0;
    padding: 10px 12px;
    text-align: left;
}

.data-table th {
    background: #dce7ef;
}

.form-row {
    margin-bottom: 14px;
}

input[type="text"],
input[type="password"],
input[type="email"],
input[type="file"],
select,
textarea {
    width: 100%;
    max-width: 420px;
    padding: 10px 12px;
    border: 1px solid #b8c8d4;
    border-radius: 8px;
    font-size: 15px;
    background: #fff;
}

input[type="submit"] {
    background: #274e68;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    font-size: 15px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background: #1d3b50;
}

img.profile-pic {
    border-radius: 14px;
    border: 1px solid #d2dde5;
    box-shadow: 0 10px 20px rgba(28, 45, 57, 0.12);
}

.inline-links {
    margin-top: 16px;
}

.inline-links a {
    margin-right: 14px;
}

.note-text {
    color: #526773;
    font-size: 15px;
}

.empty-state {
    margin-top: 16px;
    padding: 14px;
    background: #f7fafc;
    border: 1px dashed #b8c8d4;
    border-radius: 10px;
}

@media (max-width: 720px) {
    .page-shell {
        margin: 14px auto;
        padding: 14px;
    }

    .card {
        padding: 20px 18px;
    }

    .data-table {
        display: block;
        overflow-x: auto;
    }
}
</style>
