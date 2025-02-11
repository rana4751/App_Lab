function digitToWord(digit) {
    const words = [
        'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'
    ];
    return words[digit];
}

function appendToOutput(value) {
    const outputField = document.getElementById('output');
    const inputField = document.getElementById('input');

    if (inputField.value === "" && value !== "=") {
        inputField.value = value;
    } else {
        inputField.value += value;
    }

    const inputValue = inputField.value;
    const words = [];
    for (let i = 0; i < inputValue.length; i++) {
        const char = inputValue[i];
        if (!isNaN(char)) {
            words.push(digitToWord(parseInt(char)));
        } else {
            words.push(char);  
        }
    }

    const result = eval(inputField.value);
    if (!isNaN(result)) {
        const resultString = result.toString();
        const words = [];
        for (let i = 0; i < resultString.length; i++) {
            const digit = parseInt(resultString[i]);
            words.push(digitToWord(digit));
        }
        outputField.value = words.join(' ');
    } else {
        outputField.value = result;
    }
}

function clearOutput() {
    document.getElementById('output').value = "";
    document.getElementById('input').value = "";
}

function calculate() {
    const inputField = document.getElementById('input');
    const outputField = document.getElementById('output');

    try {
        const result = eval(inputField.value);
        if (!isNaN(result)) {
            const resultString = result.toString();
            const words = [];
            for (let i = 0; i < resultString.length; i++) {
                const digit = parseInt(resultString[i]);
                words.push(digitToWord(digit));
            }
            outputField.value = words.join(' ');
        } else {
            outputField.value = result;
        }
    } catch (e) {
        outputField.value = "infinite";
    }
}
