# Primeiro objetivo: Como abrir (Ler) o arquivo? Logo após o executar.
# Segundo objetivo: Leitura de dados linhas a linhas.
with open("Challenge.hex", 'r') as f:
    lines = f.readlines()
    print("Type lines:",type(lines))
    
    print("Linhas: ", lines)

# Terceiro objetivo: Parsear o documento removendo o overhead linha por linha.
 # |O quê é parsear? (Do inglês "To Parse".) Consiste em um neologismo =
  # (Os possíveis significados são: "decodificar" ; "interpretar" e dependendo do caso "converter".)

# Quarto objetivo: Obter apenas os dados do documento.

# Quinto objetivo: Criando um arquivo final apenas com linhas de dados.


# Programador IoT

#--------------------------"Programar não é fácil só não pode pular etapas"-----------------------------