# Explicação do código:

# A função codificar_qr(string, nome_arquivo) recebe uma string string e um nome de arquivo nome_arquivo como argumentos e cria um código QR a partir da string usando a função qrcode.make(). Em seguida, o código QR é salvo em um arquivo PNG usando o método save() da imagem QR.
# A função decodificar_qr(nome_arquivo) recebe um nome de arquivo nome_arquivo como argumento e carrega a imagem QR a partir do arquivo usando a função cv2.imread(). Em seguida, a função cv2.QRCodeDetector().detectAndDecode() é usada para detectar e decodificar o código QR a partir da imagem. Se a decodificação for bem-sucedida, a função retorna a string decodificada. Caso contrário, a função retorna None.
# Para usar essas funções, basta chamar codificar_qr(string, nome_arquivo) para codificar uma string em um código QR e salvá-lo em um arquivo PNG e chamar decodificar_qr(nome_arquivo) para decodificar um código QR a partir de um arquivo PNG. No exemplo acima, uma string é codificada em um QR code e salva em um arquivo PNG usando a função codificar_qr(), e o QR code é decodificado a partir do arquivo PNG usando a função decodificar_qr() e a string decodificada é exibida na tela usando a função print().
# Criado por Victor Souto. :)

import qrcode
import cv2

# Codifica uma string em um código QR e salva em um arquivo PNG
def codificar_qr(string, nome_arquivo):
    img_qr = qrcode.make(string)
    img_qr.save(nome_arquivo)

# Decodifica um código QR a partir de uma imagem e retorna a string
def decodificar_qr(nome_arquivo):
    img_qr = cv2.imread(nome_arquivo)
    detector = cv2.QRCodeDetector()
    dados, pontos, _ = detector.detectAndDecode(img_qr)
    if dados:
        return dados
    else:
        return None

# Exemplo de uso
string = "Olá, mundo!"
nome_arquivo = "qr_code.png"

# Codifica a string em um QR code e salva em um arquivo PNG
codificar_qr(string, nome_arquivo)

# Decodifica o QR code a partir do arquivo PNG e exibe a string
string_decodificada = decodificar_qr(nome_arquivo)
print(string_decodificada)
