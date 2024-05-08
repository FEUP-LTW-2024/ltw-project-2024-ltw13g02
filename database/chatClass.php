<?php
require_once(__DIR__ ."/messageClass.php");
class Chat {
    private int $id;
    private int $product;
    private string $possibleBuyer;
    private array $messages;

    public function __construct(int $id, int $product, string $possibleBuyer) {
        $this->id = $id;
        $this->product = $product;
        $this->possibleBuyer = $possibleBuyer;
        $this->messages = $this->getMessages();
    }

    public function getPossibleBuyer(): string {
        return $this->possibleBuyer;
    }

    public function setPossibleBuyer(string $possibleBuyer): void {
        $this->possibleBuyer = $possibleBuyer;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getProduct(): int {
        return $this->product;
    }

    public function setProduct(int $product): void {
        $this->product = $product;
    }

    public function getMessages(): array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT * FROM Messages
            WHERE chat = ? 
            ORDER BY messageDate DESC
        ');
        $stmt->execute(array($this->id));
        $result = $stmt->fetchAll();
        $messages = [];

        foreach ($result as $data) {
            $messages[] = new Message($data["id"], $data["messageDate"], $data["sender"], $data["chat"], $data["content"], $data["seen"]);
        }

        return $messages;
    }

    public function getInfo(): array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT Product.idProduct, Product.prodName as ProdName, Seller.idUser as SId, Seller.firstName as SFN, Seller.lastName as SLN, Seller.photo as SP, Buyer.idUser as BId, Buyer.firstName as BFN, Buyer.lastName as BLN, Buyer.photo as BP
            FROM Product, Chat, User as Seller, User as Buyer
            WHERE idChat = ? AND Chat.product = Product.idProduct AND Chat.possibleBuyer = Buyer.idUser AND Product.seller = Seller.idUser
        ');
        $stmt->execute(array($this->id));
        $info = $stmt->fetch();
        return $info;
    }

    function getLastMessage(): ?Message {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT * FROM Messages
            WHERE chat = ? 
            ORDER BY messageDate DESC
            LIMIT 1
        ');
        $stmt->execute(array($this->id));
        $data = $stmt->fetch();
        return new Message($data["id"], $data["messageDate"], $data["sender"], $data["chat"], $data["content"], $data["seen"]);
    }
}