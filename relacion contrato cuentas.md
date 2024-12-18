-   Los datos de `cuentas` y `contratos` ya están cargados en arreglos.
-   Utilizamos `map` y `filter` para vincular y filtrar los resultados.

```typescript
import * as fs from 'fs/promises';

async function main() {
  // Leer datos desde los archivos JSON
  const accountsData = JSON.parse(await fs.readFile('./cuentas.json', 'utf-8')).accounts;
  const contractsData = JSON.parse(await fs.readFile('./contratos.json', 'utf-8')).contracts;

  // Crear un mapa de contratos agrupados por customerId
  const contractMap = new Map<string, any[]>();

  contractsData.forEach((contract) => {
    if (!contractMap.has(contract.customerId)) {
      contractMap.set(contract.customerId, []);
    }
    contractMap.get(contract.customerId)?.push(contract);
  });

  // Vincular cuentas con contratos usando el mapa
  const linkedData = accountsData.map((account) => {
    const contracts = contractMap.get(account.customerId) || [];
    return {
      accountId: account.accountId,
      accountNumber: account.accountNumber,
      customerId: account.customerId,
      contracts: contracts.map((contract) => contract.contractNumber),
    };
  });

  // Filtrar resultados: solo cuentas con contratos asociados
  const filteredData = linkedData.filter((data) => data.contracts.length > 0);

  console.log('Relaciones entre cuentas y contratos:');
  console.table(filteredData);
}

main().catch((error) => console.error(error));

```

----------

### Explicación

1.  **Crear un mapa de contratos por `customerId`**:
    
    -   Agrupa todos los contratos según el `customerId` para optimizar el acceso.
2.  **Vincular cuentas con contratos**:
    
    -   Recorremos las cuentas (`map`) y para cada una, buscamos los contratos correspondientes usando el mapa.
    -   El resultado incluye:
        -   `accountId`
        -   `accountNumber`
        -   `customerId`
        -   Una lista de `contractNumber` asociados.
3.  **Filtrar cuentas con contratos**:
    
    -   Se aplica un `filter` para incluir solo las cuentas que tengan contratos vinculados.

----------

### Ejemplo de salida

Si los datos en los JSON son:

-   **Cuentas**:
    
    ```json
    [
      { "accountId": "0072000000700063", "accountNumber": "007000638801", "customerId": "01576531" },
      { "accountId": "0072000000200661", "accountNumber": "002006612072", "customerId": "01576531" }
    ]
    
    ```
    
-   **Contratos**:
    
    ```json
    [
      { "contractNumber": "000000638801", "customerId": "01576531" },
      { "contractNumber": "000006612072", "customerId": "01576531" }
    ]
    
    ```
    

El resultado será:

```
Relaciones entre cuentas y contratos:
┌─────────────────┬───────────────┬─────────────┬───────────────────────┐
│ accountId       │ accountNumber │ customerId  │ contracts             │
├─────────────────┼───────────────┼─────────────┼───────────────────────┤
│ 0072000000700063│ 007000638801  │ 01576531    │ [ '000000638801' ]    │
│ 0072000000200661│ 002006612072  │ 01576531    │ [ '000006612072' ]    │
└─────────────────┴───────────────┴─────────────┴───────────────────────┘

```

----------

