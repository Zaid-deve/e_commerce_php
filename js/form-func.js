const err = (t, m) => {
    const target = t.querySelector('.err');

    if (target != null) target.innerHTML = m;
}

const isEmail = (val) => {
    const email_pattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/

    if (email_pattern.test(val)) return true;
    return;
}

