from cryptography.fernet import Fernet
from cryptography.hazmat.primitives.ciphers import Cipher, algorithms, modes
from cryptography.hazmat.backends import default_backend

def encrypt_message_aes(message, key):
    backend = default_backend()
    cipher = Cipher(algorithms.AES(key), modes.CBC(b'\0'*16), backend=backend)
    encryptor = cipher.encryptor()
    padded_message = message + b"\0" * (16 - len(message) % 16)
    ciphertext = encryptor.update(padded_message) + encryptor.finalize()
    return ciphertext

def decrypt_message_aes(ciphertext, key):
    backend = default_backend()
    cipher = Cipher(algorithms.AES(key), modes.CBC(b'\0'*16), backend=backend)
    decryptor = cipher.decryptor()
    padded_message = decryptor.update(ciphertext) + decryptor.finalize()
    return padded_message.rstrip(b"\0")

def generate_aes_key():
    return Fernet.generate_key()

def encrypt_message_fernet(message, key):
    f = Fernet(key)
    encrypted_message = f.encrypt(message)
    return encrypted_message

def decrypt_message_fernet(encrypted_message, key):
    f = Fernet(key)
    decrypted_message = f.decrypt(encrypted_message)
    return decrypted_message

def main():
    print("Selecione um algoritmo de criptografia:")
    print("1. AES")
    print("2. Fernet")

    choice = input("Digite sua escolha (1 ou 2): ")

    if choice == '1':
        key = generate_aes_key()
        message = input("Digite a mensagem a ser criptografada: ").encode()
        ciphertext = encrypt_message_aes(message, key)
        print("Chave: ", key.hex())
        print("Mensagem criptografada: ", ciphertext.hex())
        decrypted_message = decrypt_message_aes(ciphertext, key)
        print("Mensagem descriptografada: ", decrypted_message.decode())
    elif choice == '2':
        key = Fernet.generate_key()
        message = input("Digite a mensagem a ser criptografada: ").encode()
        encrypted_message = encrypt_message_fernet(message, key)
        print("Chave: ", key.decode())
        print("Mensagem criptografada: ", encrypted_message.decode())
        decrypted_message = decrypt_message_fernet(encrypted_message, key)
        print("Mensagem descriptografada: ", decrypted_message.decode())
    else:
        print("Escolha inválida. Tente novamente.")

if __name__ == '__main__':
    main()

# O código em detalhes:

# Primeiro, o código importa algumas bibliotecas necessárias: Fernet e Cipher da biblioteca cryptography, bem como default_backend e algorithms e modes da biblioteca cryptography.hazmat.primitives.ciphers.

# Em seguida, o código define a função encrypt_message_aes(message, key) que recebe uma mensagem e uma chave como entrada e criptografa a mensagem usando o algoritmo AES. A mensagem é preenchida com bytes nulos para que tenha um comprimento múltiplo de 16 bytes, conforme exigido pelo AES. A função retorna a mensagem criptografada.

# Em seguida, o código define a função decrypt_message_aes(ciphertext, key) que recebe a mensagem criptografada e a chave como entrada e descriptografa a mensagem usando o algoritmo AES. A função retorna a mensagem descriptografada.

# Depois, o código define a função generate_aes_key() que gera uma chave aleatória para ser usada com o algoritmo AES usando a biblioteca Fernet.

# Em seguida, o código define a função encrypt_message_fernet(message, key) que recebe uma mensagem e uma chave como entrada e criptografa a mensagem usando a biblioteca Fernet. A função retorna a mensagem criptografada.

# Em seguida, o código define a função decrypt_message_fernet(encrypted_message, key) que recebe a mensagem criptografada e a chave como entrada e descriptografa a mensagem usando a biblioteca Fernet. A função retorna a mensagem descriptografada.

# A função main() apresenta um menu para o usuário selecionar qual algoritmo de criptografia deseja usar. Se o usuário selecionar o algoritmo AES, a chave é gerada aleatoriamente e a mensagem é criptografada usando a chave. Em seguida, a mensagem criptografada é descriptografada usando a chave.

# Se o usuário selecionar o algoritmo Fernet, a chave é gerada aleatoriamente e a mensagem é criptografada usando a chave. Em seguida, a mensagem criptografada é descriptografada usando a chave.

# Finalmente, a função main() é chamada para executar o programa.

# Espero que isso esclareça o código para você!