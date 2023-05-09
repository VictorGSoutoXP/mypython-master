import datetime

class PontoEletronico:
    def __init__(self):
        self.registros = []

    def bater_ponto(self):
        agora = datetime.datetime.now()
        registro = {'data': agora.date(), 'hora': agora.time()}
        self.registros.append(registro)
        print('Ponto batido com sucesso!')

    def registrar_saida(self):
        agora = datetime.datetime.now()
        ultimo_registro = self.registros[-1]
        ultimo_registro['saida'] = agora.time()
        print('Saída registrada com sucesso!')

    def registrar_almoco(self):
        agora = datetime.datetime.now()
        ultimo_registro = self.registros[-1]
        ultimo_registro['almoco'] = agora.time()
        print('Horário de almoço registrado com sucesso!')

    def horas_trabalhadas(self):
        horas_totais = datetime.timedelta()
        for i in range(0, len(self.registros), 2):
            entrada = datetime.datetime.combine(self.registros[i]['data'], self.registros[i]['hora'])
            saida = datetime.datetime.combine(self.registros[i+1]['data'], self.registros[i+1]['saida'])
            horas_totais += saida - entrada
        return horas_totais

    def horas_extras(self):
        horas_trabalhadas = self.horas_trabalhadas()
        horas_extras = horas_trabalhadas - datetime.timedelta(hours=8)
        if horas_extras < datetime.timedelta():
            return datetime.timedelta()
        else:
            return horas_extras

    def gerar_relatorio(self):
        print('===== Relatório de Ponto Eletrônico =====')
        print('Data\tEntrada\t\tAlmoço\t\tSaída')
        for registro in self.registros:
            data = registro['data'].strftime('%d/%m/%Y')
            entrada = registro['hora'].strftime('%H:%M:%S') if 'hora' in registro else '--:--:--'
            almoco = registro['almoco'].strftime('%H:%M:%S') if 'almoco' in registro else '--:--:--'
            saida = registro['saida'].strftime('%H:%M:%S') if 'saida' in registro else '--:--:--'
            print(f'{data}\t{entrada}\t{almoco}\t{saida}')
        print(f'Total de horas trabalhadas: {str(self.horas_trabalhadas())}')
        print(f'Horas extras: {str(self.horas_extras())}')

# exemplo de uso
ponto = PontoEletronico()
ponto.bater_ponto()
ponto.registrar_almoco()
ponto.registrar_saida()
ponto.gerar_relatorio()

# Este código define uma classe PontoEletronico que armazena registros de entrada, saída e horário de almoço. A classe também possui métodos para registrar horário de almoço, saída e gerar um relatório com as informações registradas.

# Para usar o código acima, basta instanciar um objeto PontoEletronico, chamar o método bater_ponto() quando o usuário bater o ponto, registrar_almoco() quando o usuário sair para o almoço e registrar_saida() quando o usuário sair do trabalho. No final do mês, o método gerar_relatorio() pode ser chamado para gerar um relatório com as informações registradas. O relatório inclui a