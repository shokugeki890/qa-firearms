<?php
require_once 'src/UserRepository.php';
require_once 'tests/integration/DatabaseTest.php';
class UserRepositoryTest extends DatabaseTest
{
    private UserRepository $repo;
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new UserRepository($this->pdo);
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->pdo->exec("DELETE FROM users");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }
    public function testRegister()
    {
        $data = [
            'username' => 'rifqi',
            'email' => 'rifqi@gmail.com',
            'password' => 'rifqi123',
        ];
        $this->assertTrue($this->repo->register($data));
        $stmt = $this->pdo->query("SELECT password FROM users WHERE email = 'rifqi@gmail.com'");
        $savedPassword = $stmt->fetchColumn();
        $this->assertNotEquals('rifqi123', $savedPassword);
        $this->assertTrue(password_verify('rifqi123', $savedPassword));
    }
    public function testEmailDuplikat()
    {
        $data = [
            'username' => 'wali',
            'email' => 'rifqi@gmail.com',
            'password' => 'wali123',
        ];
        $this->repo->register($data);
        $this->expectException(PDOException::class);
        $this->repo->register($data);
    }
    public function testNamaPanjang()
    {
        $data = [
            'username' => str_repeat('a', 50),
            'email' => 'a50kali@gmail.com',
            'password' => 'a50kali123',
        ];
        $this->assertTrue($this->repo->register($data));
    }
    public function testNamaSpesial()
    {
        $data = [
            'username' => '12!#@!',
            'email' => 'spesial@gmail.com',
            'password' => 'spesial123',
        ];
        $this->assertTrue($this->repo->register($data));
    }
    public function testCariEmail()
    {
        $this->repo->register([
            'username' => 'amba',
            'email' => 'amba@gmail.com',
            'password' => 'amba123',
        ]);
        $user = $this->repo->findByEmail('amba@gmail.com');
        $this->assertEquals('amba', $user['username']);
    }
    public function testEmailTidakAda()
    {
        $this->assertNull($this->repo->findByEmail('nihil@gmail.com'));
    }
    public function testEmailBesarKecil()
    {
        $this->repo->register([
            'username' => 'ciimut',
            'email' => 'CIIMUT@gmail.com',
            'password' => 'ciimut123',
        ]);
        $user = $this->repo->findByEmail('ciimut@gmail.com');
        $this->assertNotNull($user);
    }
    public function testTimeStamp()
    {
        $this->repo->register([
            'username' => 'reza',
            'email' => 'reza@gmail.com',
            'password' => 'reza123',
        ]);
        $user = $this->repo->findByEmail('reza@gmail.com');
        $this->assertArrayHasKey('created_at', $user);
    }
    public function testUpdate()
    {
        $this->repo->register([
            'username' => 'auditore',
            'email' => 'auditore@gmail.com',
            'password' => 'pwlama',
        ]);
        $user = $this->repo->findByEmail('auditore@gmail.com');
        $this->repo->updatePassword($user['id'], 'pwbaru');
        $updateUser = $this->repo->findByEmail('auditore@gmail.com');
        $this->assertTrue(password_verify('pwbaru', $updateUser['password']));
    }
    public function testHapusKosong()
    {
        $this->assertTrue($this->repo->delete(99));
    }
    public function testUpdatePasswordKosong()
    {
        $this->assertTrue($this->repo->updatePassword(99, 'pass'));
    }
    public function testBuatHapusRegister()
    {
        $data = [
            'username' => 'bisnis',
            'email'=>'bisnis@gmail.com',
            'password'=>'bisnis123',
        ];
        $this->repo->register($data);
        $user = $this->repo->findByEmail('bisnis@gmail.com');
        $this->repo->delete($user['id']);
        $this->assertTrue($this->repo->register($data));
    }
}
