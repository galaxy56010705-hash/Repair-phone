<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $first = filter_var($_POST['first'] ?? '', FILTER_VALIDATE_FLOAT);
    $second = filter_var($_POST['second'] ?? '', FILTER_VALIDATE_FLOAT);
    $operation = $_POST['operation'] ?? '';
    $error = null;
    if ($first === false || $second === false) {
        $error = 'Please enter two valid numbers.';
    } elseif (!in_array($operation, ['add', 'subtract', 'multiply', 'divide'], true)) {
        $error = 'Please choose a valid operation.';
    } elseif ($operation === 'divide' && $second == 0) {
        $error = 'Cannot divide by zero.';
    }
    if ($error !== null) {
        http_response_code(422);
        echo json_encode(['error' => $error]);
        exit;
    }
    $result = match ($operation) {
        'add' => $first + $second,
        'subtract' => $first - $second,
        'multiply' => $first * $second,
        'divide' => $first / $second,
    };
    if (!is_finite($result)) {
        http_response_code(422);
        echo json_encode(['error' => 'The result is too large. Try smaller numbers.']);
    } else {
        echo json_encode(['result' => $result]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <script src="/assets/calculator.js" defer></script>
</head>
<body>
    <main class="calculator">
        <h1>PHP Calculator</h1>
        <form id="calculator-form" action="/index.php" method="post">
            <label class="sr-only" for="first">First number</label>
            <input id="first" name="first" type="number" step="any" placeholder="Enter First Number" required>
            <label class="sr-only" for="operation">Operation</label>
            <select id="operation" name="operation">
                <option value="add">Addition (+)</option>
                <option value="subtract">Subtraction (−)</option>
                <option value="multiply">Multiplication (×)</option>
                <option value="divide">Division (÷)</option>
            </select>
            <label class="sr-only" for="second">Second number</label>
            <input id="second" name="second" type="number" step="any" placeholder="Enter Second Number" required>
            <button type="submit">Calculate</button>
        </form>
        <output id="result" aria-live="polite" aria-atomic="true" hidden></output>
        <p class="footer">Made with PHP <span aria-label="love">❤️</span></p>
    </main>
</body>
</html>
