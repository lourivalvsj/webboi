import csv
import re


# Função para extrair os dados dos inserts
def extract_data_from_sql(sql_file):
    with open(sql_file, 'r', encoding='utf-8') as file:
        content = file.read()

    # Regex para capturar os valores dos inserts
    pattern = re.compile(r"INSERT INTO `?(\w+)`?\s*\((.*?)\)\s*VALUES\s*\((.*?)\);", re.DOTALL)

    # Lista de dados extraídos
    data = []

    # Encontrar todos os inserts
    matches = re.findall(pattern, content)

    for match in matches:
        columns = [col.strip().replace('"', '').replace("'", "") for col in match[1].split(',')]
        values = [val.strip().replace("'", "") for val in match[2].split(',')]

        # Garantir que temos o mesmo número de colunas e valores
        if len(columns) == len(values):
            row = dict(zip(columns, values))
            data.append(row)

    return data

# Função para salvar os dados extraídos em CSV
def save_to_csv(data, output_csv):
    if data:
        # Definindo as colunas do CSV
        columns = ['name', 'uf_id', 'created_at', 'latitude', 'longitude']

        # Escrevendo os dados no arquivo CSV
        with open(output_csv, 'w', newline='', encoding='utf-8') as file:
            writer = csv.DictWriter(file, fieldnames=columns)
            writer.writeheader()
            writer.writerows(data)

        print(f"CSV gerado com sucesso: {output_csv}")
    else:
        print("Nenhum dado encontrado.")

# Caminho do seu arquivo SQL
sql_file = 'sqlCities.sql'  # Substitua pelo caminho correto do seu arquivo .sql
output_csv = 'cities.csv'  # O arquivo de saída CSV

# Extrair os dados do SQL
data = extract_data_from_sql(sql_file)

# Salvar os dados no formato CSV
save_to_csv(data, output_csv)
