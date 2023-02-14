with open("Challenge.hex", 'r') as f:
    lines = f.readlines()
    print("Type lines:",type(lines))
    
    print("Linha05: ", lines)
    # Priemiro elemento:
    print("Linha07",lines[0])
    #lines.replace("\n","")
    # Cada elemento de lines e uma string:
  


#Como quebrar as linhas?
 # ASCII: o caractere 10. Ele também é conhecido por ASCII LF, onde LF vem de line feed.
  #  A presença da barra invertida antecedendo o caractere n significa sequência de escape. 
   # Em outras palavras, estamos informando que este n não é a letra "êne", 
    # mas sim o comando de quebra de linha.
var = ":020000040802F0\n:100000003DB8F39600000000000200008CF00000F4\n:1000100000000000010200000000000000000000DD\n:0CF3D000ECAE5187499A721589EDF86C7B\n:00000001FF"

import ast
s = ast.literal_eval('0xffa')
print(s)

print ("var:",var)

var = var.replace("\n")
print("var: ", var)

lines = var.split(":")
print("lines",lines)
rawdata = []

for item in lines:
    if len(item) == 0:
        continue
    print("#####")
    bytec = item [0:2]
    print ("BYTEC:",bytec)
    addres = item[2:6]
    print ("ADDRES", addres)
    retype = item [6:8]
    print("RETYPE")
    dados = item [0:8]
    print("DADOS", dados)
    if(retype =="00"):
        rawdata.append(dados+"\n")

        
print("rawdata",rawdata)
