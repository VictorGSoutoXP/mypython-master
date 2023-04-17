# Entender o que foi realizado no ticket 122

 elif version[0] == versions.VERSION_13_3_0[0]:
            if version[1] >= versions.VERSION_13_3_0[1]:
                prolonged_gnss_mature_time = True

A palavra ELIF é uma junção de ELSE + IF, ou seja, se não foi a condição anterior, e se a condição atual for verdadeira, faça algo...

O ELIF é útil para casos onde temos várias condições que são específicas, e não cabe o uso direto de um if/else, que é algo muito geral, pois, será uma coisa ou outra, temos então apenas duas opções usando if/else. Observe que utilizando o ELIF podemos fazer vários casos de teste.

# Porquê usar? "Não precisamos indentar (dar espaço)! Podemos colocar uma ELIF embaixo de outra ELIF e nosso código não fica tão extenso horizontalmente (e escrevemos menos)."

#Exemplo
# 

idade = 45
if idade < 12:
    print('crianca')
elif idade < 18:
    print('adolescente')
elif idade < 60:
    print('adulto')
else:
    print('idoso')

se idade é menor que 12: é verdade isto? Não, então vamos para próxima condição

se idade for menor que 18: é verdade isto? Não, então vamos para próxima condição

se idade for menor que 60: é verdade isto? Sim, então printa a palavra adulto
