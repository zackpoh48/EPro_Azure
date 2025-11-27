let events = {
    onKeypress(e, data) {
        let keyCode = e.keyCode ? e.keyCode : e.which;
        // only allow number and one dot
        if (
            (keyCode < 48 || keyCode > 57) &&
            (keyCode !== 46 || data.indexOf(".") != -1)
        ) {
            // 46 is dot
            e.preventDefault();
        }

        // restrict to 2 decimal places
        if (
            data != null &&
            data.indexOf(".") > -1 &&
            data.split(".")[1].length > 1
        ) {
            e.preventDefault();
        }
    },
    onKeypressAcceptNegativeNum(e, data) {
        let keyCode = e.keyCode ? e.keyCode : e.which;
        // only allow number, one dot and minus sign
        if (
            (keyCode < 48 || keyCode > 57) &&
            (keyCode !== 46 || data.indexOf(".") != -1) &&
            (keyCode !== 45 || data.indexOf("-") != -1)
        ) {
            // 46 is dot
            // 45 is minus
            e.preventDefault();
        }

        // restrict to 2 decimal places
        if (
            data != null &&
            data.indexOf(".") > -1 &&
            data.split(".")[1].length > 1
        ) {
            e.preventDefault();
        }
    }
};

export default events;
