<?php

const N_MAX = 10 ** 2;

$i = [];

$i[1] = [];
$i[1][0] = gmp_init(-1);
$i[1][1] = gmp_init(1);

for ($n = 2; $n <= N_MAX; $n++) {
    $i[$n] = [];
    foreach ($i[$n - 1] as $p => $c) {
        $i[$n][$p] = gmp_init(-$n) * $c;
    }
    $i[$n][$n] = gmp_init(1);
}

echo "Primitive Functions of `(log(x))^n`\n";

foreach ($i as $n => $p_c_hash) {
    echo sprintf('n = %3d: x(', $n);
    echo implode(' ', array_filter(array_map(function ($p, $c) {
        if (gmp_cmp($c, 0) === 0) {
            return null;
        }
        if (gmp_cmp($c, 0) > 0) {
            $sign = '+';
        } else {
            $sign = '-';
        }
        if ($p === 0) {
            return $sign . ' ' . gmp_strval(gmp_abs($c));
        }
        if (gmp_cmp(gmp_abs($c), 1) === 0) {
            $val = '';
        } else {
            $val = gmp_strval(gmp_abs($c));
        }
        if ($p === 1) {
            return $sign . ' ' . $val . 'log(x)';
        }
        return $sign . ' ' . $val . '(log(x))^' . $p;
    }, array_keys($p_c_hash), array_values($p_c_hash))));
    echo ")\n";
}
