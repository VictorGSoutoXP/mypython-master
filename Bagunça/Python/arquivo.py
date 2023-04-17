try:
    nome_arquivo = input('Nome do arquivo a ser editado:')
    arquivo = open(nome_arquivo, 'r+')
except FileNotFoundError:
    arquivo = open(nome_arquivo, 'w+')
    arquivo.writelines(u'Arquivo criado pois nao existia')
#faca o que quiser
arquivo.close()