<?php
include 'config.php';
$GLOBALS['pdo'] = connectDatabase($dsn, $pdoOptions, $PARAMS);

/**
 * Connect to database using PDO
 */
function connectDatabase(string $dsn, array $pdoOptions, array $params): PDO
{
    try {
        return new PDO(
            $dsn,
            $params['USER'],
            $params['PASSWORD'],
            $pdoOptions
        );
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function generateData(){
    $CATEGORIES = ['laptop','phone','monitor','ssd','accessories'];

    $faker = Faker\Factory::create();

// Generate a random date between two dates
    $startDate = '2020-01-01 00:00:00';
    $endDate = 'now';

// Using dateTimeBetween() to generate a random date within a given range
    $randomDate = $faker->dateTimeBetween($startDate, $endDate)->format('Y.m.d H:i:s');
    $randomDescription = $faker->paragraph();
    $randomCategory = $faker->randomElement($CATEGORIES);
    $productName = ucfirst($faker->words(3, true)); //three random words as a string for product name, with ucfirst the first word becomes an uppercase
    $productPrice = $faker->numberBetween(1500, 100000);

    return [$productName, $productPrice, $randomDescription, $randomCategory, $randomDate];
}

function insertProducts(PDO $pdo, string $name, string $price, string $desc, string $cat, string $date): void
{
    $sql = "INSERT INTO products
            (product_name, product_price, product_description, product_category, creation_date)
            VALUES (:name, :price, :desc, :cat, :date);";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':price', $price, PDO::PARAM_STR);
    $stmt->bindValue(':desc', $desc, PDO::PARAM_STR);
    $stmt->bindValue(':cat', $cat, PDO::PARAM_STR);
    $stmt->bindValue(':date', $date, PDO::PARAM_STR);
    $stmt->execute();
}

function getCategoryTypes(PDO $pdo): array{
    $sql = "SELECT DISTINCT product_category FROM products";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function searchProducts(PDO $pdo, ?string $name, ?int $minPrice, ?int$maxPrice, ?string $category): array {
    $sqlWhere = "WHERE 1";
    $params = [];

    if($name !== null && $name !== ''){
        $sqlWhere .= " AND product_name LIKE :name";
        $params[":name"] = "%$name%";
    }

    if($category !== null && $category !== 'all'){
        $sqlWhere .= " AND product_category = :category";
        $params[":category"] = $category;
    }

    if($minPrice !== null){
        $sqlWhere .= " AND product_price >= :minPrice";
        $params[":minPrice"] = $minPrice;
    }

    if($maxPrice !== null){
        $sqlWhere .= " AND product_price <= :maxPrice";
        $params[":maxPrice"] = $maxPrice;
    }

    $sql = "SELECT product_name, product_price, product_category, LEFT(product_description, 60) AS short_desc
            FROM products
            $sqlWhere";

    $stmt = $pdo->prepare($sql);

    $stmt->execute($params);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlStats = "SELECT COUNT(*) AS count, MIN(product_price) AS min_price, MAX(product_price) AS max_price, AVG(product_price) AS avg_price
                 FROM products
                 $sqlWhere";
    $stmtStats = $pdo->prepare($sqlStats);
    $stmtStats->execute($params);
    $agg = $stmtStats->fetch(PDO::FETCH_ASSOC);

    if($agg['count'] === 0){
        $agg['min_price'] = 0;
        $agg['max_price'] = 0;
        $agg['avg_price'] = 0;
    }

    return [
        'products' => $products,
        'stats'    => $agg
    ];
}