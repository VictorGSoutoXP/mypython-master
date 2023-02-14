
with open("fw_extensor_1.2.1.hex", 'r') as f:
    lines = f.readlines()
    print("Type lines:",type(lines))
    print("Linha: ", lines)
    print("Linha",lines[0])

rawdata = []

for item in lines:
    if len(item) == 0:
        continue
    print("#####")
    print("linha.. ",item)
    #Bytec recebe item de um a tres.
    bytec = item [1:3]
    print ("BYTEC:",bytec)
    addres = item[3:7]
    print ("ADDRES", addres)
    retype = item [7:9]
    print("RETYPE",retype)
    dados = item [9:]
    dados = dados [:-3]
    #Converte str para inteiro
    print("DADOS", dados)
    if(retype =="00"):
        rawdata.append(dados+"\n")


nome_arquivo = 'Owl'    
f = open(nome_arquivo, 'w+')
# For cria um contexto
for item in rawdata: 
    f.write(item)
f.close()

