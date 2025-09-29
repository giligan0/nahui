import os
import re

def check_migration_files(directory):
    mismatches = []

    # Regex to extract table names from migration files
    create_table_pattern = re.compile(r"Schema::create\('(\w+)'\s*,")
    drop_table_pattern = re.compile(r"Schema::dropIfExists\('(\w+)'\)")

    for filename in os.listdir(directory):
        if filename.endswith(".php"):
            filepath = os.path.join(directory, filename)
            with open(filepath, 'r', encoding='utf-8') as file:
                content = file.read()

                # Extract table names
                create_match = create_table_pattern.search(content)
                drop_match = drop_table_pattern.search(content)

                # Check if the file name matches the table name
                table_name = None
                if create_match:
                    table_name = create_match.group(1)
                elif drop_match:
                    table_name = drop_match.group(1)

                if table_name:
                    # Extract the expected table name from the file name
                    expected_table_name = "_".join(filename.split("_")[4:]).replace(".php", "")
                    if expected_table_name.startswith("create_") and expected_table_name.endswith("_table"):
                        expected_table_name = expected_table_name[7:-6]  # Remove "create_" and "_table"

                    if table_name != expected_table_name:
                        mismatches.append({
                            "file": filename,
                            "expected": expected_table_name,
                            "actual": table_name
                        })

    return mismatches


# Directory containing migration files
migrations_dir = "c:\\xampp\\htdocs\\nahui\\database\\migrations"

# Run the check
mismatches = check_migration_files(migrations_dir)

# Print results
if mismatches:
    print("Mismatched migrations:")
    for mismatch in mismatches:
        print(f"File: {mismatch['file']}, Expected: {mismatch['expected']}, Actual: {mismatch['actual']}")
else:
    print("All migration files match their table names.")